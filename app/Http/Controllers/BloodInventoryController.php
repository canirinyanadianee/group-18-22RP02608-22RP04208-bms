<?php

namespace App\Http\Controllers;

use App\Models\BloodInventory;
use App\Models\BloodBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BloodInventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = BloodInventory::query()
            ->select('blood_type', 
                    DB::raw('SUM(quantity) as total_quantity'),
                    DB::raw('COUNT(DISTINCT blood_bank_id) as bank_count'))
            ->groupBy('blood_type');

        // Filter by blood bank if specified
        if ($request->filled('blood_bank_id')) {
            $query->where('blood_bank_id', $request->blood_bank_id);
        }

        $bloodInventory = $query->get();
        $bloodBanks = BloodBank::all();

        // Get detailed inventory by blood bank
        $detailedInventory = BloodInventory::with('bloodBank')
            ->when($request->filled('blood_bank_id'), function($query) use ($request) {
                $query->where('blood_bank_id', $request->blood_bank_id);
            })
            ->when($request->filled('blood_type'), function($query) use ($request) {
                $query->where('blood_type', $request->blood_type);
            })
            ->orderBy('blood_type')
            ->orderBy('blood_bank_id')
            ->paginate(10);

        return view('blood-inventory.index', compact('bloodInventory', 'bloodBanks', 'detailedInventory'));
    }

    public function update(Request $request, BloodInventory $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory->update($validated);

        return redirect()->route('blood-inventory.index')
            ->with('success', 'Blood inventory updated successfully.');
    }
} 