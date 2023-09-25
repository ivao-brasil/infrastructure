<?php

namespace IvaoBrasil\Infrastructure;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use IvaoBrasil\Infrastructure\Auth\Data\AuthProviders;
use IvaoBrasil\Infrastructure\Auth\Services\IvaoLegacyProvider;
use IvaoBrasil\Infrastructure\Auth\Services\IvaoOauthSocialiteService;
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
            ->hasConfigFile();
    }

    public function packageBooted()
    {
        if (!config('user.oauth.enabled', false)) {
            return;
        }

        /** @var \Laravel\Socialite\SocialiteManager */
        $socialite = $this->app->make(\Laravel\Socialite\Contracts\Factory::class);
        $socialite->extend(
            AuthProviders::IVAO_OAUTH->value,
            function () use ($socialite) {
                $config = config('ivao-infrastructure.auth.oauth');

                return $socialite->buildProvider(
                    IvaoOauthSocialiteService::class,
                    $config
                );
            }
        );

        $socialite->extend(
            AuthProviders::IVAO_LEGACY->value,
            function (Application $app) {
                $config = config('ivao-infrastructure.auth.legacy');

                $config = config('');
                $redirect = Str::startsWith($config["redirect"], '/')
                    ? $this->app->make('url')->to($config["redirect"])
                    : $config["redirect"];
                $loginUrl = array_key_exists("ivao-dev-login-url", $config) ? $config["ivao-dev-login-url"] : null;
                $apiUrl = array_key_exists("ivao-dev-login-api", $config) ? $config["ivao-dev-login-api"] : null;

                return new IvaoLegacyProvider(
                    $app->make(Request::class),
                    $app->make(LegacyHttpClient::class),
                    $redirect,
                    $loginUrl,
                    $apiUrl
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
