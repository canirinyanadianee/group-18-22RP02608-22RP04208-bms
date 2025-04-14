<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BloodBankController;

Route::get('/blood-banks/available/{bloodType}', [BloodBankController::class, 'getAvailableByBloodType']); 