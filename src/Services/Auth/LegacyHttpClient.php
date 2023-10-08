<?php
namespace IvaoBrasil\Infrastructure\Services\Auth;

use Illuminate\Support\Facades\Http;
use IvaoBrasil\Infrastructure\Auth\Exception\DomainNotAllowedException;

class LegacyHttpClient
{
    public function getUserFromToken(string $token, string $apiUrl): array
    {
        if ($token === 'error') {
            throw new DomainNotAllowedException($apiUrl);
        }

        $response = Http::get($apiUrl, [
            "token" => $token,
            "type" => "json"
        ]);

        $content = json_decode($response->getBody(), true);

        return ($content && array_key_exists("result", $content) && $content["result"]) ? $content : [];
    }
}
