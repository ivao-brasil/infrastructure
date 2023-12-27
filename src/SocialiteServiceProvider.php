<?php

namespace IvaoBrasil\Infrastructure;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use IvaoBrasil\Infrastructure\Services\Auth\IvaoLegacyProvider;
use IvaoBrasil\Infrastructure\Services\Auth\IvaoOauthProvider;
use IvaoBrasil\Infrastructure\Services\Auth\LegacyHttpClient;
use Laravel\Socialite\Contracts\Factory;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function boot(Factory $socialite): void
    {
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
    }
}