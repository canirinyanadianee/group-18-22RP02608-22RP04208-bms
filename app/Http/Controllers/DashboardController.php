<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BloodBank;
use App\Models\BloodDonation;
use App\Models\BloodInventory;
use App\Models\BloodRequest;
use App\Models\DonationDrive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'donor') {
            return $this->donorDashboard($user);
        } elseif ($user->role === 'patient') {
            return $this->patientDashboard($user);
        } elseif ($user->role === 'hospital') {
            return $this->hospitalDashboard($user);
        }
        
        // Fallback to a default dashboard or throw an error
        abort(403, 'Invalid user role');
    }

    protected function donorDashboard($user)
    {
        $data = [
            'totalDonations' => BloodDonation::where('donor_id', $user->id)->count(),
            'lastDonation' => BloodDonation::where('donor_id', $user->id)->latest()->first(),
            'appointments' => BloodDonation::where('donor_id', $user->id)
                ->where('status', 'scheduled')
                ->get(),
            'nextEligibleDate' => $this->calculateNextEligibleDate($user->id)
        ];

        return view('dashboards.donor', $data);
    }

    protected function patientDashboard($user)
    {
        $data = [
            'activeRequests' => BloodRequest::where('requester_id', $user->id)
                ->whereIn('status', ['pending', 'approved'])
                ->count(),
            'fulfilledRequests' => BloodRequest::where('requester_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'bloodRequests' => BloodRequest::where('requester_id', $user->id)
                ->whereIn('status', ['pending', 'approved'])
                ->latest()
                ->get()
        ];

        return view('dashboards.patient', $data);
    }

    protected function hospitalDashboard($user)
    {
        $inventory = $this->getBloodInventory($user->id);
        
        // Get the blood bank associated with this hospital
        $bloodBank = BloodBank::where('hospital_id', $user->id)->first();
        
        // Get all registered donors
        $donors = User::where('role', 'donor')
            ->with(['bloodDonations' => function($query) {
                $query->latest();
            }])
            ->withCount(['bloodDonations as is_eligible' => function($query) {
                $query->where('created_at', '<=', now()->subDays(56))
                    ->where('status', 'completed');
            }])
            ->latest()
            ->take(10)
            ->get()
            ->map(function($donor) {
                $donor->lastDonation = $donor->bloodDonations->first();
                return $donor;
            });

        // Get pending blood requests
        $pendingRequests = BloodRequest::with('requester')
            ->when($bloodBank, function($query) use ($bloodBank) {
                return $query->where('blood_bank_id', $bloodBank->id);
            })
            ->whereIn('status', ['pending', 'processing'])
            ->latest()
            ->take(10)
            ->get();

        // Get upcoming donation drives
        $donationDrives = DonationDrive::where('hospital_id', $user->id)
            ->where('date', '>=', now())
            ->withCount('registrations')
            ->orderBy('date')
            ->take(6)
            ->get();

        $data = [
            'inventory' => $inventory,
            'donors' => $donors,
            'pendingRequests' => $pendingRequests,
            'donationDrives' => $donationDrives
        ];

        return view('dashboards.hospital', $data);
    }

    protected function calculateNextEligibleDate($donorId)
    {
        $lastDonation = BloodDonation::where('donor_id', $donorId)
            ->where('status', 'completed')
            ->latest()
            ->first();

        if (!$lastDonation) {
            return null;
        }

        // Standard waiting period is 56 days (8 weeks) between donations
        return $lastDonation->donation_date->addDays(56);
    }

    protected function getBloodInventory($hospitalId)
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $inventory = array_fill_keys($bloodTypes, 0); // Initialize all blood types with 0

        // Get the blood bank for this hospital
        $bloodBank = BloodBank::where('hospital_id', $hospitalId)->first();
        
        if ($bloodBank) {
            // Get inventory for each blood type
            $inventoryRecords = BloodInventory::where('blood_bank_id', $bloodBank->id)
                ->where('status', 'available')
                ->selectRaw('blood_type, SUM(quantity_ml) as total')
                ->groupBy('blood_type')
                ->pluck('total', 'blood_type');

            // Update inventory array with actual values
            foreach ($inventoryRecords as $type => $total) {
                if (isset($inventory[$type])) {
                    $inventory[$type] = $total;
                }
            }
        }

        return $inventory;
    }
}
