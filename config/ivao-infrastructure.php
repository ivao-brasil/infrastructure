<?php
return [
    'auth' => [
        'oauth' => [
            'client_id' => env('IVAO_OAUTH_CLIENT_ID'),
            'client_secret' => env('IVAO_OAUTH_CLIENT_SECRET'),
            'redirect' => "/{$routePrefix}/provider/{$oauthProviderName}/callback",
            'openid_url' => 'https://api.ivao.aero/.well-known/openid-configuration'
        ],
    ]
];
