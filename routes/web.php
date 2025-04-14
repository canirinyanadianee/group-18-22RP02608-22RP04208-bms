<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BloodBankController;
use App\Http\Controllers\BloodDonationController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HospitalAccessController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\BloodInventoryController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Blood Banks
    Route::get('/blood-banks/dashboard', [BloodBankController::class, 'dashboard'])
        ->name('blood-banks.dashboard');
    Route::get('/blood-banks', [BloodBankController::class, 'index'])
        ->name('blood-banks.index');
    Route::get('/blood-banks/{bloodBank}', [BloodBankController::class, 'show'])
        ->name('blood-banks.show');
    Route::put('/blood-banks/{bloodBank}/inventory', [BloodBankController::class, 'updateInventory'])
        ->name('blood-banks.update-inventory');

    // Donors
    Route::get('/donors', [DonorController::class, 'index'])->name('donors.index');
    Route::get('/donors/{donor}', [DonorController::class, 'show'])->name('donors.show');
    Route::get('/donors/{donor}/donations', [DonorController::class, 'donations'])->name('donors.donations');
    Route::get('/donors/{donor}/appointments', [DonorController::class, 'appointments'])->name('donors.appointments');

    // Blood Donations
    Route::get('/blood-donations', [BloodDonationController::class, 'index'])->name('blood-donations.index');
    Route::get('/blood-donations/create', [BloodDonationController::class, 'create'])->name('blood-donations.create');
    Route::post('/blood-donations', [BloodDonationController::class, 'store'])->name('blood-donations.store');
    Route::get('/blood-donations/{donation}', [BloodDonationController::class, 'show'])->name('blood-donations.show');
    Route::get('/blood-donations/{donation}/edit', [BloodDonationController::class, 'edit'])->name('blood-donations.edit');
    Route::put('/blood-donations/{donation}', [BloodDonationController::class, 'update'])->name('blood-donations.update');

    // Blood Requests
    Route::get('/blood-requests', [BloodRequestController::class, 'index'])->name('blood-requests.index');
    Route::get('/blood-requests/create', [BloodRequestController::class, 'create'])->name('blood-requests.create');
    Route::post('/blood-requests', [BloodRequestController::class, 'store'])->name('blood-requests.store');
    Route::get('/blood-requests/{request}', [BloodRequestController::class, 'show'])->name('blood-requests.show');
    Route::get('/blood-requests/{request}/edit', [BloodRequestController::class, 'edit'])->name('blood-requests.edit');
    Route::put('/blood-requests/{request}', [BloodRequestController::class, 'update'])->name('blood-requests.update');
    Route::delete('/blood-requests/{request}', [BloodRequestController::class, 'destroy'])->name('blood-requests.destroy');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/blood-requests/create', [BloodRequestController::class, 'create'])->name('blood-requests.create');
    Route::post('/blood-requests', [BloodRequestController::class, 'store'])->name('blood-requests.store');
    Route::get('/blood-requests/{request}', [BloodRequestController::class, 'show'])->name('blood-requests.show');
    Route::get('/blood-requests/{request}/edit', [BloodRequestController::class, 'edit'])->name('blood-requests.edit');
    Route::put('/blood-requests/{request}', [BloodRequestController::class, 'update'])->name('blood-requests.update');

    // Blood Inventory
    Route::get('/blood-inventory', [BloodInventoryController::class, 'index'])->name('blood-inventory.index');
    Route::put('/blood-inventory/{bloodInventory}', [BloodInventoryController::class, 'update'])->name('blood-inventory.update');
});

// Hospital Access Routes
Route::middleware(['auth', 'role:hospital'])->group(function () {
    Route::get('/hospital/donors', [HospitalAccessController::class, 'donors'])->name('hospital.donors');
    Route::get('/hospital/donors/{donor}', [HospitalAccessController::class, 'donorDetails'])->name('hospital.donor.details');
    Route::get('/hospital/patients', [HospitalAccessController::class, 'patients'])->name('hospital.patients');
    Route::get('/hospital/patients/{patient}', [HospitalAccessController::class, 'patientDetails'])->name('hospital.patient.details');
});
