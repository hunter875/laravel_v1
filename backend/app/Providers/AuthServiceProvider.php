<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\AdminPolicy; // Đảm bảo đúng namespace (Policies, không phải Polices)
use App\Models\User;
use App\Models\Profile;
use App\Policies\ProfilePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => AdminPolicy::class,
        Profile::class => ProfilePolicy::class, // Register the ProfilePolicy
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        // Định nghĩa thêm các Gate nếu cần
        Gate::define('AccessAdmin', [AdminPolicy::class, 'view']);
    }
}
