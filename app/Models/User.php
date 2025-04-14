<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'blood_type',
        'address',
        'city',
        'state',
        'country',
        'role',
        'language_code',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDonor()
    {
        return $this->role === 'donor';
    }

    public function isHospital()
    {
        return $this->role === 'hospital';
    }

    public function isPatient()
    {
        return $this->role === 'patient';
    }

    public function bloodBank()
    {
        return $this->hasOne(BloodBank::class, 'hospital_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_donation_date' => 'date',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * The attributes that should be validated.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'phone' => 'required|string',
        'blood_type' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'role' => 'required|string|in:admin,donor,hospital,patient',
        'language_code' => 'required|exists:languages,code'
    ];

    public function bloodDonations()
    {
        return $this->hasMany(BloodDonation::class, 'donor_id');
    }

    public function bloodRequests()
    {
        return $this->hasMany(BloodRequest::class, 'requester_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }
}
