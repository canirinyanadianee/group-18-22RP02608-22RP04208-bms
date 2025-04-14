<?php

namespace App\Http\Controllers;

use App\Models\BloodDonation;
use App\Models\BloodInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BloodDonationController extends Controller
{
    public function index(Request $request)
    {
        $donations = BloodDonation::with(['donor', 'bloodBank'])
            ->when($request->user()->isDonor(), function ($query) use ($request) {
                return $query->where('donor_id', $request->user()->id);
            })
            ->when($request->user()->isHospital(), function ($query) use ($request) {
                return $query->where('blood_bank_id', $request->user()->bloodBank->id);
            })
            ->get();
        
        return response()->json($donations);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blood_bank_id' => 'required|exists:blood_banks,id',
            'blood_type' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'donation_date' => 'required|date',
            'quantity_ml' => 'required|integer|min:200|max:500',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $donation = BloodDonation::create([
            'donor_id' => $request->user()->id,
            'blood_bank_id' => $request->blood_bank_id,
            'blood_type' => $request->blood_type,
            'donation_date' => $request->donation_date,
            'quantity_ml' => $request->quantity_ml,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        return response()->json($donation, 201);
    }

    public function show(BloodDonation $donation)
    {
        return response()->json($donation->load(['donor', 'bloodBank']));
    }

    public function update(Request $request, BloodDonation $donation)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected,completed',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $donation->update($request->only(['status', 'notes']));

        if ($request->status === 'completed') {
            BloodInventory::create([
                'blood_bank_id' => $donation->blood_bank_id,
                'blood_type' => $donation->blood_type,
                'quantity_ml' => $donation->quantity_ml,
                'expiry_date' => now()->addDays(42), // Blood expires after 42 days
                'status' => 'available',
                'donation_id' => $donation->id
            ]);
        }

        return response()->json($donation);
    }
} 