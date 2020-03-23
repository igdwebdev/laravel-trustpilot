<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trustpilot Unit Id
    |--------------------------------------------------------------------------
    |
    | The unit id of your trustpilot account.
    |
     */
    'unit_id' => env('TRUSTPILOT_UNIT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Trustpilot API Access Token
    |--------------------------------------------------------------------------
    |
    | The API access key and secret for your trustpilot account.
    |
     */
    'api' => [
        'key' => env('TRUSTPILOT_API_KEY'),
        'secret' => env('TRUSTPILOT_API_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Trustpilot Credentials
    |--------------------------------------------------------------------------
    |
    | The login credentials for your trustpilot account.
    |
     */
    'credentials' => [
        'username' => env('TRUSTPILOT_USERNAME'),
        'password' => env('TRUSTPILOT_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Trustpilot API Endpoints
    |--------------------------------------------------------------------------
    |
    | The API Endpoints for the trustpilot API.
    |
     */
    'endpoints' => [
        'default' => env('TRUSTPILOT_DEFAULT_ENDPOINT', 'https://api.trustpilot.com/v1'),
        'invitation' => env('TRUSTPILOT_INVITATION_ENDPOINT', 'https://invitations-api.trustpilot.com/v1'),
        'oauth' => env('TRUSTPILOT_OAUTH_ENDPOINT', 'https://api.trustpilot.com/v1/oauth/oauth-business-users-for-applications'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Package cache settings
    |--------------------------------------------------------------------------
    |
    | The cache prefix to be used for cache items in this package.
    |
     */
    'cache' => [
        'prefix' => env('TRUSTPILOT_CACHE_PREFIX', 'trustpilot'),
    ],

];
