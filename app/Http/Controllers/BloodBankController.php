<?php

namespace App\Http\Controllers;

use App\Models\BloodBank;
use App\Models\BloodInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BloodBankController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $user = Auth::user();
        
        if ($user && $user->role === 'hospital') {
            $bloodBank = $user->bloodBank;
            if ($bloodBank) {
                $inventory = $bloodBank->getAllBloodTypesInventory();
                $recentDonations = $bloodBank->bloodDonations()
                    ->with('donor')
                    ->latest()
                    ->take(5)
                    ->get();
                $recentRequests = $bloodBank->bloodRequests()
                    ->with('requester')
                    ->latest()
                    ->take(5)
                    ->get();
                return view('blood-banks.dashboard', compact('bloodBank', 'inventory', 'recentDonations', 'recentRequests'));
            }
        }
        
        $bloodBanks = BloodBank::where('is_active', true)
            ->with('hospital')
            ->paginate(10);
            
        return view('blood-banks.index', compact('bloodBanks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'license_number' => 'required|string|unique:blood_banks'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $bloodBank = BloodBank::create($request->all());
        return response()->json($bloodBank, 201);
    }

    public function show(BloodBank $bloodBank)
    {
        $inventory = $bloodBank->getAllBloodTypesInventory();
        return view('blood-banks.show', compact('bloodBank', 'inventory'));
    }

    public function update(Request $request, BloodBank $bloodBank)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'address' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
            'phone' => 'string',
            'email' => 'email',
            'license_number' => 'string|unique:blood_banks,license_number,' . $bloodBank->id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $bloodBank->update($request->all());
        return response()->json($bloodBank);
    }

    public function destroy(BloodBank $bloodBank)
    {
        $bloodBank->update(['is_active' => false]);
        return response()->json(null, 204);
    }

    public function inventory(BloodBank $bloodBank)
    {
        $inventory = $bloodBank->bloodInventory()
            ->where('status', 'available')
            ->where('expiry_date', '>', now())
            ->get();
        
        return response()->json($inventory);
    }

    public function updateInventory(Request $request, BloodBank $bloodBank)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'hospital' || !$user->bloodBank || $user->bloodBank->id !== $bloodBank->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'blood_type' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'quantity_ml' => 'required|integer|min:0',
            'expiry_date' => 'required|date|after:today'
        ]);

        BloodInventory::updateOrCreate(
            [
                'blood_bank_id' => $bloodBank->id,
                'blood_type' => $validated['blood_type']
            ],
            [
                'quantity_ml' => $validated['quantity_ml'],
                'expiry_date' => $validated['expiry_date']
            ]
        );

        return redirect()->route('blood-banks.dashboard')
            ->with('success', 'Blood inventory updated successfully.');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'hospital') {
            abort(403, 'Unauthorized action.');
        }

        $bloodBank = $user->bloodBank;
        if (!$bloodBank) {
            return redirect()->route('blood-banks.index')
                ->with('error', 'Please set up your blood bank first.');
        }

        $inventory = $bloodBank->getAllBloodTypesInventory();
        $recentDonations = $bloodBank->bloodDonations()
            ->with('donor')
            ->latest()
            ->take(5)
            ->get();
        $recentRequests = $bloodBank->bloodRequests()
            ->with('requester')
            ->latest()
            ->take(5)
            ->get();

        return view('blood-banks.dashboard', compact('bloodBank', 'inventory', 'recentDonations', 'recentRequests'));
    }
} 
