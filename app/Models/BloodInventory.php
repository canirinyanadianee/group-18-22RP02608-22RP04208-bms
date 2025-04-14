<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'blood_bank_id',
        'blood_type',
        'quantity'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'quantity_ml' => 'integer'
    ];

    /**
     * Get the blood bank that owns this inventory.
     */
    public function bloodBank(): BelongsTo
    {
        return $this->belongsTo(BloodBank::class);
    }

    public function donation()
    {
        return $this->belongsTo(BloodDonation::class);
    }
} 