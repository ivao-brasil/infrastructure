<?php

namespace IvaoBrasil\Infrastructure\Tests\Feature\Auth;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

class IvaoOauthProviderTest extends TestCase
{
    use WithWorkbench;

    private const GUZZLE_HANDLER_CONFIG = 'services.ivao-oauth.guzzle.handler';
    private string $openIdConfig = '';
    private string $oauthResponse = '';

    #[DefineEnvironment('usesMockedRedirect')]
    public function testRedirectsAUser()
    {
        $response = $this->get($this->getAuthUrl() . '/redirect');

        $response->assertRedirectContains('https://sso.ivao.aero/authorize');
    }

    #[DefineEnvironment('usesMockedTokenAndUser')]
    public function testAuthenticateTheUserInCallbackAction()
    {
        $response = $this->get($this->getAuthUrl()  . '/callback');

        $response->assertJson(json_decode($this->getOauthResponse(), true));
    }

    /**
     * Define routes setup.
     *
     * @param  Router  $router
     * @return void
     */
    protected function defineRoutes($router): void
    {
        $router->middleware(['web'])
            ->prefix('auth/provider/ivao-oauth')
            ->group(function () {
                Route::get('/redirect', function () {
                    return Socialite::driver('ivao-oauth')
                        ->stateless()
                        ->redirect();
                });
                Route::get('/callback', function () {
                    /** @var User $user */
                    $user = Socialite::driver('ivao-oauth')
                        ->stateless()
                        ->user();
                    return FacadesResponse::json($user->getRaw());
                });
            });
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function usesMockedRedirect(Application $app): void
    {
        $this->defineBaseEnvironment($app);

        $mock = new MockHandler([
            new Response(body: $this->getOpenIdConfig())
        ]);

        $handlerStack = HandlerStack::create($mock);

        tap(
            $app['config'],
            fn (Repository $config) => $config->set(self::GUZZLE_HANDLER_CONFIG, $handlerStack)
        );
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function usesMockedTokenAndUser(Application $app): void
    {
        $this->defineBaseEnvironment($app);

        $mock = new MockHandler([
            new Response(body: $this->getOpenIdConfig()),
            new Response(body: '{"access_token": "token123"}'),
            new Response(body: $this->getOauthResponse())
        ]);
        $handlerStack = HandlerStack::create($mock);

        tap(
            $app['config'],
            fn (Repository $config) => $config->set(self::GUZZLE_HANDLER_CONFIG, $handlerStack)
        );
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    private function defineBaseEnvironment(Application $app): void
    {
        tap($app['config'], function (Repository $config) {
            $config->set('services.ivao-oauth', [
                'client_id' => '123',
                'client_secret' => '123',
                'redirect' => $this->getAuthUrl(),
                'openid_config_url' => 'http://localhost'
            ]);
        });
    }

    private function getAuthUrl(): string
    {
        return "/auth/provider/ivao-oauth";
    }

    private function getOpenIdConfig(): string
    {
        if (!$this->openIdConfig) {
            $this->openIdConfig = file_get_contents(__DIR__ . '/TestFiles/openidConfiguration.json');
        }

        return $this->openIdConfig;
    }

    private function getOauthResponse(): string
    {
        if (!$this->oauthResponse) {
            $this->oauthResponse = file_get_contents(__DIR__ . '/TestFiles/oauthResponse.json');
        }

        return $this->oauthResponse;
    }
}
