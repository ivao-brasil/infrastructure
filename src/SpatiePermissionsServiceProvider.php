<?php

namespace IvaoBrasil\Infrastructure;

use Composer\InstalledVersions;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use IvaoBrasil\Infrastructure\Listeners\Auth\LoginListener;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

class SpatiePermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function boot(): void
    {
        if (!InstalledVersions::isInstalled('spatie/laravel-permission')) {
            return;
        }

        if (config('ivao-infrastructure.enable_auto_role_assign')) {
            Gate::after($this->afterGateValidations(...));
            Event::listen(Login::class, [LoginListener::class, 'handle']);
        }

        /** @var Router $router */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('permission', PermissionMiddleware::class);
        $router->aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
    }

    private function afterGateValidations(User $user): bool
    {
        return $user->hasRole(
            Arr::pluck(
                config('ivao-infrastructure.super_admin_roles', []),
                'value'
            )
        );
    }
}