<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodDonation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'blood_bank_id',
        'blood_type',
        'donation_date',
        'quantity_ml',
        'status',
        'notes'
    ];

    protected $casts = [
        'donation_date' => 'date',
        'quantity_ml' => 'integer'
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function bloodBank()
    {
        return $this->belongsTo(BloodBank::class);
    }

    public function bloodInventory()
    {
        return $this->hasOne(BloodInventory::class);
    }
} 