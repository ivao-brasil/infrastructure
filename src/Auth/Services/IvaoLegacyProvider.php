<?php

namespace IvaoBrasil\Infrastructure\Auth\Services;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Provider as ProviderContract;
use Laravel\Socialite\One\User;

class IvaoLegacyProvider implements ProviderContract
{
    private const IVAO_LOGIN_REDIRECT_URL = 'https://login.ivao.aero/index.php';

    public function __construct(
        private Request $request,
        private LegacyHttpClient $httpClient,
        private ?string $redirectUrl = self::IVAO_LOGIN_REDIRECT_URL,
        private ?string $loginUrl,
        private ?string $apiUrl
    ) {
    }

    /**
     * Redirect the user of the application to the IVAO's Login Page.
     *
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        return new RedirectResponse($this->loginUrl . '?url=' . $this->redirectUrl);
    }

    /**
     * Get the User instance for the authenticated user.
     *
     * @return \Laravel\Socialite\Contracts\User
     */
    public function user(): \Laravel\Socialite\Contracts\User
    {
        $token = $this->extractTokenFromUrl();
        $rawUserData = $this->httpClient->getUserFromToken($token, $this->apiUrl);
        if (!$rawUserData) {
            return null;
        }

        return (new User())->setRaw($rawUserData)->map([
            'token' => $token,
            'id' => $rawUserData['vid'],
            'name' => $rawUserData['firstname'] . ' ' . $rawUserData['lastname'],
            'vid' => $rawUserData['vid'],
            'firstName' => $rawUserData['firstname'],
            'lastName' => $rawUserData['lastname'],
            'atcRating' => $rawUserData['ratingatc'],
            'pilotRating' => $rawUserData['ratingpilot'],
            'division' => $rawUserData['division'],
            'country' => $rawUserData['country'],
            'staff' => $rawUserData['staff'] ? explode(':', $rawUserData['staff']) : [],
            'isNpoMember' => $rawUserData['isNpoMember'] != 0,
            'isHqPilot' => $rawUserData['hq_pilot'] != 0,
            'secondsAsPilot' => $rawUserData['hours_pilot'],
            'secondsAsAtc' => $rawUserData['hours_atc'],
        ]);
    }

    private function extractTokenFromUrl(): string
    {
        return $this->request->input('IVAOTOKEN');
    }
}
