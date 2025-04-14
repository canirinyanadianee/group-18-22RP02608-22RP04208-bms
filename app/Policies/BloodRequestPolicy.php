<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BloodRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class BloodRequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, BloodRequest $request)
    {
        return $user->isAdmin() || 
               $user->id === $request->requester_id || 
               ($user->isHospital() && $user->bloodBank->id === $request->blood_bank_id);
    }

    public function create(User $user)
    {
        return $user->isPatient() || $user->isHospital();
    }

    public function update(User $user, BloodRequest $request)
    {
        return $user->id === $request->requester_id || 
               ($user->isHospital() && $user->bloodBank->id === $request->blood_bank_id);
    }

    public function delete(User $user, BloodRequest $request)
    {
        return $user->isAdmin() || $user->id === $request->requester_id;
    }
} 