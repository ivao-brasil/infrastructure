<?php

namespace IvaoBrasil\Infrastructure;

use Illuminate\Contracts\Debug\ExceptionHandler;
use IvaoBrasil\Infrastructure\Contracts\Auth\RoleRegistrarInterface;
use IvaoBrasil\Infrastructure\Exceptions\Handler;
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
    public array $bindings = [
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
    }

    public function registeringPackage(): void
    {
        $this->app->when(RoleRegistrarService::class)
            ->needs('$divisionCode')
            ->giveConfig('ivao-infrastructure.division_code');

        $this->app->when(RoleRegistrarService::class)
            ->needs('$roleMapping')
            ->giveConfig('ivao-infrastructure.role_mapping');

        $this->app->singleton(ExceptionHandler::class, Handler::class);
    }

    public function bootingPackage(): void
    {
        $this->publishes([
            $this->package->basePath('/../resources/views/errors') => base_path("resources/views/errors"),
        ], "{$this->packageView($this->package->viewNamespace)}-views");

        $this->app->register(SocialiteServiceProvider::class);
        $this->app->register(SpatiePermissionsServiceProvider::class);
        $this->app->register(LaravelModulesServiceProvider::class);
    }
}
