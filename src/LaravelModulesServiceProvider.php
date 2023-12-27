<?php

namespace IvaoBrasil\Infrastructure;

use Composer\InstalledVersions;
use Illuminate\Support\ServiceProvider;
use IvaoBrasil\Infrastructure\Console\BuildModuleResources;
use IvaoBrasil\Infrastructure\Console\WatchModuleResources;

class LaravelModulesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (!InstalledVersions::isInstalled('nwidart/laravel-modules')) {
            return;
        }

        $this->commands([
            BuildModuleResources::class,
            WatchModuleResources::class
        ]);
    }
}