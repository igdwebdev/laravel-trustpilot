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
    | The API access token for your trustpilot account.
    |
     */
    'api' => [
        'access_token' => env('TRUSTPILOT_ACCESS_TOKEN'),
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
    ],

];
