<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\ProfileRepositoryInterface;
use App\Repositories\ProfileRepository;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\RoleRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class); 
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }

    public function boot()
    {
        //
    }
}
