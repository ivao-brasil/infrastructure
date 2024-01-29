# ``ivao-brasil/infrastructure``

## Services config for oauth:
```php
    'ivao-legacy' => [
        'redirect' => env('IVAO_LEGACY_REDIRECT_URI'),
        'login_url' => 'https://login.ivao.aero/index.php',
        'api_url' => 'https://login.ivao.aero/api.php'
    ],
    'ivao-oauth' => [
        'client_id' => env('IVAO_OAUTH_CLIENT_ID'),
        'client_secret' => env('IVAO_OAUTH_CLIENT_SECRET'),
        'redirect' => env('IVAO_OAUTH_REDIRECT_URI'),
        'openid_config_url' => 'https://api.ivao.aero/.well-known/openid-configuration'
    ],
```
