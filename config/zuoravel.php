<?php

return [
    'debug' => env('ZUORA_SANDBOX', false),

    'version' => env('ZUORA_VERSION', 'v1'),

    'client_id' => env('ZUORA_CLIENT_ID', ''),
    'client_secret' => env('ZUORA_CLIENT_SECRET', ''),

    'access_key' => env('ZUORA_ACCESS_KEY'), // apiAccessKeyId for UserAuth method
    'secret_access_key' => env('ZUORA_SECRET_ACCESS_KEY'), // apiSecretAccessKey for UserAuth method

    // Values are UserAuth or ClientAuth (recommended)
    'authentication' => 'ClientAuth',

    // Values are 'session' or 'cache' (recommended)
    'storage' => 'cache',

    'entities' => [
        //
    ],

    'hostedPage' => [
        'apiSecurityKey' => env('ZUORA_API_SECURITY_KEY'),

        'tenantId' => '',

        'pageId' => '',

        'height' => 400,

        'width' => 700,

        'signatureMethod' => 'v2', // or v1

        'scriptVersion' => '1.3.1',

        'paymentGateway' => ''
    ]

];
