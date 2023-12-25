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

    /** @var bool */
    protected $stateless = true;

    private ?array $openIdConfig = null;

    /**
     * Create a new provider instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $clientId
     * @param  string  $clientSecret
     * @param  string  $redirectUrl
     * @param  array  $guzzle
     * @return void
     */
    public function __construct(Request $request, $clientId, $clientSecret, $redirectUrl, $guzzle = [])
    {
        $this->guzzle = $guzzle;
        $this->request = $request;
        $this->clientId = $clientId;
        $this->redirectUrl = route($redirectUrl);
        $this->clientSecret = $clientSecret;
    }

    public function getOpenIdConfig(): array
    {
        if (!$this->openIdConfig) {
            $response = $this->getHttpClient()->get(config('services.ivao-oauth.openid_config_url'));
            $responseContents = $response->getBody()->getContents();
            $this->openIdConfig = json_decode($responseContents, true);
        }

        return $this->openIdConfig;
    }

    /**
     *  @param  string $state
     *
     *  @return string
     */
    protected function getAuthUrl($state)
    {
        $authEndpoint = $this->getOpenIdConfig()['authorization_endpoint'];

        return $this->buildAuthUrlFromBase($authEndpoint, $state);
    }

    /**
     *  @return  string
     */
    protected function getTokenUrl()
    {
        return $this->getOpenIdConfig()['token_endpoint'];
    }

    /**
     *  @param  string $token
     *
     *  @throws  GuzzleException
     *
     *  @return  array|mixed
     */
    protected function getUserByToken($token)
    {
        $userInfoEndpoint = $this->getOpenIdConfig()['userinfo_endpoint'];

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
        $newUser = new User($user);
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
            'secondsAsPilot' => Arr::first(
                $user['hours'],
                fn (array $item) => $item['type'] === 'pilot',
                default: ['hours' => 0]
            )['hours'],
            'secondsAsAtc' => Arr::first(
                $user['hours'],
                fn (array $item) => $item['type'] === 'atc',
                default: ['hours' => 0]
            )['hours'],
        ]);

        return $newUser;
    }

    /**
     * Get the POST fields for the token request.
     *
     * @param  string  $code
     * @return array
     */
    protected function getTokenFields($code)
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'redirect_uri' => $this->redirectUrl,
            'grant_type' => 'authorization_code',
        ];
    }
}
