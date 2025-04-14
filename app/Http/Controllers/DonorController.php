<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BloodDonation;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index()
    {
        $donors = User::where('role', 'donor')
            ->with(['bloodDonations' => function($query) {
                $query->latest();
            }])
            ->withCount(['bloodDonations as is_eligible' => function($query) {
                $query->where('created_at', '<=', now()->subDays(56))
                    ->where('status', 'completed');
            }])
            ->latest()
            ->paginate(10);

        return view('donors.index', compact('donors'));
    }

    public function show(User $donor)
    {
        if ($donor->role !== 'donor') {
            abort(404);
        }

        $donations = $donor->bloodDonations()
            ->with('bloodBank')
            ->latest()
            ->get();

        return view('donors.show', compact('donor', 'donations'));
    }

    public function donations(User $donor)
    {
        if ($donor->role !== 'donor') {
            abort(404);
        }

        $donations = $donor->bloodDonations()
            ->with('bloodBank')
            ->latest()
            ->paginate(10);

        return view('donors.donations', compact('donor', 'donations'));
    }

    public function appointments(User $donor)
    {
        if ($donor->role !== 'donor') {
            abort(404);
        }

        $appointments = $donor->bloodDonations()
            ->where('status', 'scheduled')
            ->with('bloodBank')
            ->latest()
            ->paginate(10);

        return view('donors.appointments', compact('donor', 'appointments'));
    }
} 