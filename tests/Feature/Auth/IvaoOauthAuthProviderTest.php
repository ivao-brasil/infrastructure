<?php

namespace IvaoBrasil\Tracker\Tests\Feature;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use IvaoBrasil\User\Data\AuthProviders;
use IvaoBrasil\User\IvaoOauthServiceProvider;

class IvaoOauthAuthProviderTest extends TestCase
{
    use RefreshDatabase;

    private string $openIdConfig;
    private string $oauthResponse;

    protected function setUp(): void
    {
        parent::setUp();

        $this->openIdConfig = file_get_contents(__DIR__ . '/TestFiles/openidConfiguration.json');
        $this->oauthResponse = file_get_contents(__DIR__ . '/TestFiles/oauthResponse.json');

        config()->set('user', [
            'route_prefix' => 'auth',
            'division_code' => 'BR',
            'oauth' => [
                'enabled' => true,
                'client_id' => '123',
                'client_secret' => '123',
                'redirect' => $this->getAuthUrl(),
                'openid_url' => 'http://oauthtest.com'
            ]
        ]);

        /** @var IvaoOauthServiceProvider */
        $socialite = $this->app->make(IvaoOauthServiceProvider::class, ['app' => $this->app]);
        $socialite->boot();
    }

    public function testRedirectsAUser()
    {
        $mock = new MockHandler([
            new Response(body: $this->openIdConfig)
        ]);
        $handlerStack = HandlerStack::create($mock);
        config()->set('user.oauth.guzzle.handler', $handlerStack);

        $response = $this->get($this->getAuthUrl() . '/redirect');

        $response->assertRedirectContains('https://sso.ivao.aero/authorize');
    }

    public function testAuthenticateTheUserInCallbackAction()
    {
        $mock = new MockHandler([
            new Response(body: $this->openIdConfig),
            new Response(body: 'token123'),
            new Response(body: $this->oauthResponse)
        ]);
        $handlerStack = HandlerStack::create($mock);
        config()->set('user.oauth.guzzle.handler', $handlerStack);

        $response = $this->get($this->getAuthUrl()  . '/callback');

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', ['vid' => 444590]);
        $this->assertAuthenticated();
    }

    private function getAuthUrl(): string
    {
        $oauthProviderName = AuthProviders::IVAO_OAUTH->value;
        return "/auth/provider/{$oauthProviderName}";
    }
}
