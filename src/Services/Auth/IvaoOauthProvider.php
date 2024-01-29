<?php

namespace IvaoBrasil\Infrastructure\Services\Auth;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
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

    private const OPENID_CACHE_KEY = 'ivao-oauth-openid';
    private const OPENID_CACHE_TTL = 180;

    /**
     * @throws GuzzleException
     */
    public function openIdConfig(string $key): string
    {
        $config = Cache::remember(self::OPENID_CACHE_KEY, self::OPENID_CACHE_TTL, function() {
            $response = $this->getHttpClient()->get(config('services.ivao-oauth.openid_config_url'));
            $responseContents = $response->getBody()->getContents();
            return json_decode($responseContents, true);
        });

        return $config[$key];
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
        [
            'pilot' => $pilotTime, 
            'atc' => $atcTime, 
            'staff' => $staffTime
        ] = $this->getOnlineTime($user);

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
            'secondsAsPilot' => $pilotTime,
            'secondsAsAtc' => $atcTime,
            'secondsAsStaff' => $staffTime,
        ]);

        return $newUser;
    }

    private function getOnlineTime(array $user): array
    {
        $hoursData = collect(data_get($user, 'hours', []));
        $hourTypes = ['pilot', 'atc', 'staff'];
        $result = [];

        foreach ($hourTypes as $type) {
            $hourData = $hoursData->first(fn (array $hourItem) => $hourItem['type'] === $type, []);
            $result[$type] = data_get($hourData, 'hours', 0);
        }
        
        return $result;
    }
}
