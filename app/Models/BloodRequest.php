<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id',
        'blood_bank_id',
        'patient_name',
        'blood_type',
        'quantity_ml',
        'urgency_level',
        'reason',
        'hospital_name',
        'hospital_address',
        'required_date',
        'status',
    ];

    protected $casts = [
        'required_date' => 'datetime',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function bloodBank()
    {
        return $this->belongsTo(BloodBank::class);
    }
} 