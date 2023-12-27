<?php

namespace IvaoBrasil\Infrastructure\Services\Auth;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class IvaoOauthProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * @var string[]
     */
    protected $scopes = [
        'openid',
        'profile'
    ];

    /** @var string */
    protected $scopeSeparator = ' ';

    private ?array $openIdConfig = null;

    /**
     * @throws GuzzleException
     */
    public function openIdConfig(string $key): string
    {
        if (!$this->openIdConfig) {
            $response = $this->getHttpClient()->get(config('services.ivao-oauth.openid_config_url'));
            $responseContents = $response->getBody()->getContents();
            $this->openIdConfig = json_decode($responseContents, true);
        }

        return $this->openIdConfig[$key];
    }

    /**
     * @param string $state
     *
     * @return string
     * @throws GuzzleException
     */
    protected function getAuthUrl($state): string
    {
        $authEndpoint = $this->openIdConfig('authorization_endpoint');

        return $this->buildAuthUrlFromBase($authEndpoint, $state);
    }

    /**
     * @return  string
     * @throws GuzzleException
     */
    protected function getTokenUrl(): string
    {
        return $this->openIdConfig('token_endpoint');
    }

    /**
     * @param string $token
     *
     * @return  array|mixed
     * @throws  GuzzleException
     *
     */
    protected function getUserByToken($token): mixed
    {
        $userInfoEndpoint = $this->openIdConfig('userinfo_endpoint');

        $response = $this->getHttpClient()->get($userInfoEndpoint, [
            'headers' => [
                'cache-control' => 'no-cache',
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function mapUserToObject(array $user): User
    {
        $newUser = new User();
        $newUser->setRaw($user)->map([
            'id' => $user['id'],
            'email' => data_get($user, 'email'),
            'nickname' => $user['publicNickname'],
            'name' => $user['firstName'] . ' ' . $user['lastName'],
            'vid' => $user['id'],
            'firstName' => $user['firstName'],
            'lastName' => $user['lastName'],
            'atcRating' => data_get($user, 'rating.atcRating.id'),
            'pilotRating' => data_get($user, 'rating.pilotRating.id'),
            'division' => $user['divisionId'],
            'country' => $user['countryId'],
            'staff' => data_get($user, 'userStaffPositions.*.id'),
            'secondsAsPilot' => data_get($user, 'hours.pilot', 0),
            'secondsAsAtc' => data_get($user, 'hours.atc', 0),
        ]);

        return $newUser;
    }
}
