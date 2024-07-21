<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//SERVICES:
use App\Repositories\Services\AdminService;
use App\Repositories\Services\UserService;

//INTERFACES:
use App\Repositories\Interfaces\AdminInterface;
use App\Repositories\Interfaces\UserInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdminInterface::class, AdminService::class);
        $this->app->bind(UserInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
