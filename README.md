# ``ivao-brasil/infrastructure``

## Services config for oauth:
```php
    'ivao-legacy' => [
        'redirect' => '/auth/provider/ivao-legacy/callback',
        'login_url' => 'https://login.ivao.aero/index.php',
        'api_url' => 'https://login.ivao.aero/api.php'
    ],
    'ivao-oauth' => [
        'client_id' => env('IVAO_OAUTH_CLIENT_ID'),
        'client_secret' => env('IVAO_OAUTH_CLIENT_SECRET'),
        'redirect' => '/auth/provider/ivao-oauth/callback',
        'openid_url' => 'https://api.ivao.aero/.well-known/openid-configuration'
    ],
```
