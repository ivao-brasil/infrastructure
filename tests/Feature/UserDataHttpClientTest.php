<?php


namespace Tests;


use GuzzleHttp\ClientInterface;
use IvaoSocialite\Exception\DomainNotAllowedException;
use IvaoSocialite\UserDataHttpClient;
use PHPUnit\Framework\TestCase;

class UserDataHttpClientTest extends TestCase
{
    private $httpClient;

    public function setUp(): void
    {
        parent::setUp();
        $this->httpClient = new UserDataHttpClient($this->createMock(ClientInterface::class));
    }

    public function testShouldThrowExceptionOnInvalidDomain()
    {
        $invalidDomainToken = 'error';

        $this->expectException(DomainNotAllowedException::class);
        $this->expectExceptionMessage('This domain is not allowed to use the Login API! Contact the System Administrator');
        $this->httpClient->getUserFromToken($invalidDomainToken, null);
    }

}
