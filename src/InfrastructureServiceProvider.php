<?php

namespace IvaoBrasil\Infrastructure;

use Composer\InstalledVersions;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use IvaoBrasil\Infrastructure\Console\BuildModuleResources;
use IvaoBrasil\Infrastructure\Console\WatchModuleResources;
use IvaoBrasil\Infrastructure\Services\Auth\IvaoLegacyProvider;
use IvaoBrasil\Infrastructure\Services\Auth\IvaoOauthProvider;
use IvaoBrasil\Infrastructure\Services\Auth\LegacyHttpClient;
use IvaoBrasil\Infrastructure\Contracts\Auth\RoleRegistrarInterface;
use IvaoBrasil\Infrastructure\Exceptions\Handler;
use IvaoBrasil\Infrastructure\Listeners\Auth\LoginListener;
use IvaoBrasil\Infrastructure\Services\Auth\RoleRegistrarService;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InfrastructureServiceProvider extends PackageServiceProvider
{
    /**
     * The container's bindings.
     *
     * @var array[]
     */
    public $bindings = [
        RoleRegistrarInterface::class => RoleRegistrarService::class
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('ivao-infrastructure')
            ->hasConfigFile()
            ->hasMigrations([
                '2023_11_11_205558_create_permission_tables',
                '2023_11_11_205600_create_core_user_roles'
            ]);

        if (InstalledVersions::isInstalled('nwidart/laravel-modules')) {
            $package->hasCommands([
                BuildModuleResources::class,
                WatchModuleResources::class
            ]);
        }
    }

    public function registeringPackage()
    {
        $this->app->when(RoleRegistrarService::class)
            ->needs('$divisionCode')
            ->giveConfig('ivao-infrastructure.auth.division_code');

        $this->app->when(RoleRegistrarService::class)
            ->needs('$roleMapping')
            ->giveConfig('ivao-infrastructure.auth.role_mapping');

        $this->app->singleton(ExceptionHandler::class, Handler::class);

        Event::listen(Login::class, [LoginListener::class, 'handle']);
    }

    public function bootingPackage()
    {
        $this->publishes([
            $this->package->basePath('/../resources/views/errors') => base_path("resources/views/errors"),
        ], "{$this->packageView($this->package->viewNamespace)}-views");
    }

    public function packageBooted()
    {
        /** @var \Laravel\Socialite\SocialiteManager */
        $socialite = $this->app->make(\Laravel\Socialite\Contracts\Factory::class);
        $socialite->extend(
            'ivao-oauth',
            function () use ($socialite) {
                $config = config('services.ivao-oauth');
                return $socialite->buildProvider(
                    IvaoOauthProvider::class,
                    $config
                );
            }
        );

        $socialite->extend(
            'ivao-legacy',
            function (Application $app) {
                $config = config('services.ivao-legacy');

                return new IvaoLegacyProvider(
                    $app->make(Request::class),
                    $app->make(LegacyHttpClient::class),
                    $config['redirect'],
                    $config['login_url'],
                    $config['api_url']
                );
            }
        );

        Gate::after(function (User $user) {
            return $user->hasRole(
                Arr::pluck(config('ivao-infrastructure.auth.super_admin_roles', []), 'value')
            );
        });

        /** @var Router $router */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('role', \Spatie\Permission\Middlewares\RoleMiddleware::class);
        $router->aliasMiddleware('permission', \Spatie\Permission\Middlewares\PermissionMiddleware::class);
        $router->aliasMiddleware('role_or_permission', \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class);
    }
}
