<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'telnyx' => [
        'api_key'              => env('TELNYX_API_KEY'),
        'from_number'          => env('TELNYX_FROM_NUMBER'),
        'messaging_profile_id' => env('TELNYX_MESSAGING_PROFILE_ID'),
        'default_country_code' => env('TELNYX_DEFAULT_COUNTRY_CODE', '1'),
        'connection_id'        => env('TELNYX_CONNECTION_ID'),
        'sip_username'         => env('TELNYX_SIP_USERNAME'),
        'sip_password'         => env('TELNYX_SIP_PASSWORD'),
    ],

];
