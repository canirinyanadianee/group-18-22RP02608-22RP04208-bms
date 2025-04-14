<?php

namespace App\Providers;

use App\Models\BloodRequest;
use App\Policies\BloodRequestPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        BloodRequest::class => BloodRequestPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
} 