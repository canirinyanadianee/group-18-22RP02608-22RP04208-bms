<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hospital_id',
        'address',
        'city',
        'state',
        'country',
        'phone',
        'email',
        'license_number',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }

    public function bloodInventory()
    {
        return $this->hasMany(BloodInventory::class);
    }

    public function bloodDonations()
    {
        return $this->hasMany(BloodDonation::class);
    }

    public function bloodRequests()
    {
        return $this->hasMany(BloodRequest::class);
    }

    public function getBloodTypeQuantity($bloodType)
    {
        return $this->bloodInventory()
            ->where('blood_type', $bloodType)
            ->sum('quantity_ml');
    }

    public function getAllBloodTypesInventory()
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $inventory = [];

        foreach ($bloodTypes as $type) {
            $inventory[$type] = $this->getBloodTypeQuantity($type);
        }

        return $inventory;
    }
} 
