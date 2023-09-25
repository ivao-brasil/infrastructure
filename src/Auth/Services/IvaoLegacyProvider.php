<?php

namespace IvaoBrasil\Infrastructure\Auth\Services;

use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use IvaoBrasil\Infrastructure\Auth\Exception\InvalidUserDataException;
use Laravel\Socialite\Contracts\Provider as ProviderContract;
use Laravel\Socialite\One\User;

class IvaoLegacyProvider implements ProviderContract
{
    public function __construct(
        private Request $request,
        private LegacyHttpClient $httpClient,
        private string $redirectUrl,
        private string $loginUrl,
        private string $apiUrl
    ) {
    }

    /**
     * Redirect the user of the application to the IVAO's Login Page.
     *
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        $redirectUrl = Str::startsWith($this->redirectUrl, '/')
                    ? App::make('url')->to($this->redirectUrl)
                    : $this->redirectUrl;

        return new RedirectResponse($this->loginUrl . '?url=' . $redirectUrl);
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
            throw new InvalidUserDataException();
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
