<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_drive_id',
        'donor_id',
        'time_slot',
        'status',
        'notes'
    ];

    protected $casts = [
        'time_slot' => 'datetime'
    ];

    public function donationDrive()
    {
        return $this->belongsTo(DonationDrive::class);
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }
}
