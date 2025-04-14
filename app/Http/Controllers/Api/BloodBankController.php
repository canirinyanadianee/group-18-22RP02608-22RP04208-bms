<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodBank;
use Illuminate\Http\Request;

class BloodBankController extends Controller
{
    public function getAvailableByBloodType($bloodType)
    {
        $bloodBanks = BloodBank::where('is_active', true)
            ->with(['bloodInventory' => function($query) use ($bloodType) {
                $query->where('blood_type', $bloodType);
            }])
            ->get()
            ->map(function($bank) {
                return [
                    'id' => $bank->id,
                    'name' => $bank->name,
                    'available_quantity' => $bank->bloodInventory->sum('quantity')
                ];
            });

        return response()->json($bloodBanks);
    }
} 
