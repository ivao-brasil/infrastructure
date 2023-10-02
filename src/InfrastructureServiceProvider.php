<?php

namespace IvaoBrasil\Infrastructure;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use IvaoBrasil\Infrastructure\Auth\Services\IvaoLegacyProvider;
use IvaoBrasil\Infrastructure\Auth\Services\IvaoOauthProvider;
use IvaoBrasil\Infrastructure\Auth\Services\LegacyHttpClient;
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
    }

    private function getMigrationNames(): array
    {
        $mainPath = __DIR__ . '/../migrations/';
        $directories = glob($mainPath . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        return array_map(fn (string $path) => basename($path), $paths);
    }
}
