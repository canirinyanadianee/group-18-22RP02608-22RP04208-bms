<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\BloodBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BloodRequestController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = BloodRequest::query();

        // Apply filters
        if ($request->filled('blood_type')) {
            $query->where('blood_type', $request->blood_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('urgency_level')) {
            $query->where('urgency_level', $request->urgency_level);
        }

        if ($request->filled('blood_bank_id')) {
            $query->where('blood_bank_id', $request->blood_bank_id);
        }

        // Apply sorting
        if ($request->filled('sort')) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->latest();
        }

        $bloodRequests = $query->paginate(10);
        $bloodBanks = BloodBank::all();

        return view('blood-requests.index', compact('bloodRequests', 'bloodBanks'));
    }

    public function create()
    {
        $bloodBanks = BloodBank::where('is_active', true)
            ->whereHas('bloodInventory', function($query) {
                $query->where('quantity', '>', 0);
            })
            ->get();
        return view('blood-requests.create', compact('bloodBanks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'blood_type' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'quantity' => 'required|integer|min:1',
            'blood_bank_id' => 'required|exists:blood_banks,id',
            'urgency_level' => 'required|string|in:Low,Medium,High,Critical',
            'required_date' => 'required|date|after_or_equal:today',
            'hospital_name' => 'required|string|max:255',
            'hospital_address' => 'required|string|max:255',
            'reason' => 'required|string|max:1000',
        ]);

        $validated['status'] = 'Pending';

        BloodRequest::create($validated);

        return redirect()->route('blood-requests.index')
            ->with('success', 'Blood request created successfully.');
    }

    public function show(BloodRequest $bloodRequest)
    {
        return view('blood-requests.show', compact('bloodRequest'));
    }

    public function edit(BloodRequest $bloodRequest)
    {
        $bloodBanks = BloodBank::where('is_active', true)->get();
        return view('blood-requests.edit', compact('bloodRequest', 'bloodBanks'));
    }

    public function update(Request $request, BloodRequest $bloodRequest)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'blood_type' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'quantity' => 'required|integer|min:1',
            'blood_bank_id' => 'required|exists:blood_banks,id',
            'urgency_level' => 'required|string|in:Low,Medium,High,Critical',
            'required_date' => 'required|date|after_or_equal:today',
            'hospital_name' => 'required|string|max:255',
            'hospital_address' => 'required|string|max:255',
            'reason' => 'required|string|max:1000',
            'status' => 'required|string|in:Pending,Approved,Rejected,Completed',
        ]);

        $bloodRequest->update($validated);

        return redirect()->route('blood-requests.index')
            ->with('success', 'Blood request updated successfully.');
    }

    public function destroy(BloodRequest $bloodRequest)
    {
        $bloodRequest->delete();

        return redirect()->route('blood-requests.index')
            ->with('success', 'Blood request deleted successfully.');
    }
} 