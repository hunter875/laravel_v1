<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Services\ProfileService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Target [App\Repositories\UserRepositoryInterface] is not instantiable while building [App\Http\Controllers\UserController, App\Services\UserService].
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        
        $this->app->bind(UserService::class, UserService::class);

        $this->app->bind(ProfileService::class, ProfileService::class);


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
