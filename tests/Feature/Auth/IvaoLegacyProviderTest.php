<?php

namespace IvaoBrasil\Infrastructure\Tests\Unit\Auth;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use IvaoBrasil\Infrastructure\Exceptions\InvalidUserDataException;
use IvaoBrasil\Infrastructure\Services\Auth\IvaoLegacyProvider;
use IvaoBrasil\Infrastructure\Services\Auth\LegacyHttpClient;
use Orchestra\Testbench\TestCase;

class IvaoLegacyProviderTest extends TestCase
{
    public function testGenerateRedirectToCorrectUrl()
    {
        $loginCallbackUrl = "https://br.ivao.aero";
        $provider = $this->makeProvider([
            "redirectUrl" => $loginCallbackUrl
        ]);

        $response = $provider->redirect();

        $this->assertTrue($response->isRedirection());
        $this->assertEquals("https://login.ivao.aero/index.php?url=https://br.ivao.aero", $response->getTargetUrl());
    }

    public function testGetUserWithInvalidToken()
    {
        $provider = $this->makeProvider([
            "request" => (function () {
                $requestMock = $this->createMock(Request::class);
                $requestMock->expects($this->once())
                    ->method('input')
                    ->with('IVAOTOKEN')
                    ->willReturn("INVALID_TOKEN");

                return $requestMock;
            })()
        ]);

        $this->expectException(InvalidUserDataException::class);
        $this->expectExceptionMessage('The user data from remote is missing or invalid');

        $provider->user();
    }

    private function makeProvider(array $dependencies = [])
    {
        $parameters = [
            "request" => $this->createMock(Request::class),
            "httpClient" => new LegacyHttpClient(new Client()),
            "redirect" => "https://br.ivao.aero",
            "login_url" => "https://login.ivao.aero/index.php",
            "api_url" => "https://login.ivao.aero/api.php",
            ...$dependencies
        ];

        return new IvaoLegacyProvider(
            $parameters["request"],
            $parameters["httpClient"],
            $parameters["redirect"],
            $parameters["login_url"],
            $parameters["api_url"]
        );
    }
}
