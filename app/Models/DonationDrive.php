<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationDrive extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'title',
        'description',
        'location',
        'date',
        'start_time',
        'end_time',
        'target_units',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'target_units' => 'integer'
    ];

    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }

    public function registrations()
    {
        return $this->hasMany(DonationRegistration::class);
    }
}
