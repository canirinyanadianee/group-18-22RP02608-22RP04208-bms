<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BloodDonation;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class HospitalAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:hospital']);
    }

    public function donors()
    {
        $donors = User::where('role', 'donor')
            ->withCount('bloodDonations')
            ->paginate(10);

        return view('hospital.donors', compact('donors'));
    }

    public function donorDetails(User $donor)
    {
        if ($donor->role !== 'donor') {
            abort(404);
        }

        $donations = BloodDonation::where('donor_id', $donor->id)
            ->with('bloodBank')
            ->latest()
            ->get();

        return view('hospital.donor-details', compact('donor', 'donations'));
    }

    public function patients()
    {
        $patients = User::where('role', 'patient')
            ->withCount('bloodRequests')
            ->paginate(10);

        return view('hospital.patients', compact('patients'));
    }

    public function patientDetails(User $patient)
    {
        if ($patient->role !== 'patient') {
            abort(404);
        }

        $requests = BloodRequest::where('patient_id', $patient->id)
            ->with('bloodBank')
            ->latest()
            ->get();

        return view('hospital.patient-details', compact('patient', 'requests'));
    }
} 