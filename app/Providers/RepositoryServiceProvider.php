<?php

namespace App\Providers;

use App\Contracts\Authentication\PermissionInterface;
use App\Contracts\Authentication\RoleInterface;
use App\Contracts\Authentication\UserInterface;
use App\Repositories\Authentication\PermissionRepository;
use App\Repositories\Authentication\RoleRepository;
use App\Repositories\Authentication\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PermissionInterface::class, PermissionRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
