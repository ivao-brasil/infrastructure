<?php
namespace IvaoBrasil\Infrastructure\Tests\Unit\Auth;

use GuzzleHttp\ClientInterface;
use IvaoBrasil\Infrastructure\Auth\Exception\DomainNotAllowedException;
use IvaoBrasil\Infrastructure\Auth\Services\LegacyHttpClient;
use PHPUnit\Framework\TestCase;

class LegacyHttpClientTest extends TestCase
{
    private LegacyHttpClient $httpClient;

    public function setUp(): void
    {
        parent::setUp();
        $this->httpClient = new LegacyHttpClient($this->createMock(ClientInterface::class));
    }

    public function testShouldThrowExceptionOnInvalidDomain()
    {
        $invalidDomainToken = 'error';

        $this->expectException(DomainNotAllowedException::class);
        $this->expectExceptionMessage('The domain http://test.com is not allowed to use the Login API! Contact the System Administrator');
        $this->httpClient->getUserFromToken($invalidDomainToken, 'http://test.com');
    }

}
