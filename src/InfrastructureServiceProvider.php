<?php

namespace IvaoBrasil\Infrastructure;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use IvaoBrasil\Infrastructure\Services\Auth\IvaoLegacyProvider;
use IvaoBrasil\Infrastructure\Services\Auth\IvaoOauthProvider;
use IvaoBrasil\Infrastructure\Services\Auth\LegacyHttpClient;
use IvaoBrasil\Infrastructure\Contracts\Auth\RoleRegistrarInterface;
use IvaoBrasil\Infrastructure\Listeners\Auth\LoginListener;
use IvaoBrasil\Infrastructure\Models\Core\User;
use IvaoBrasil\Infrastructure\Services\Auth\RoleRegistrarService;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
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
            ->hasMigrations($this->getMigrationNames())
            ->runsMigrations()
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $this->app->when(RoleRegistrarService::class)
            ->needs('$divisionCode')
            ->giveConfig('ivao-infrastructure.auth.division_code');

        $this->app->when(RoleRegistrarService::class)
            ->needs('$roleMapping')
            ->giveConfig('ivao-infrastructure.auth.role_mapping');

        Event::listen(Login::class, [LoginListener::class, 'handle']);
    }

    public function packageBooted()
    {
        /** @var \Laravel\Socialite\SocialiteManager */
        $socialite = $this->app->make(\Laravel\Socialite\Contracts\Factory::class);
        $socialite->extend(
            'ivao-oauth',
            function () use ($socialite) {
                $config = config('ivao-infrastructure.auth.oauth');
                return $socialite->buildProvider(
                    IvaoOauthProvider::class,
                    $config
                );
            }
        );

        $socialite->extend(
            'ivao-legacy',
            function (Application $app) {
                $config = config('ivao-infrastructure.auth.legacy');

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
    }

    private function getMigrationNames(): array
    {
        $migrationsDir = __DIR__ . '/../database/migrations/';
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($migrationsDir)
        );

        $migrations = [];
        foreach ($files as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isDir()) {
                continue;
            }

            $migrations[] = str_replace('.php', '',  str_replace($migrationsDir, '', $file->getPathname()));
        }

        return $migrations;
    }
}
