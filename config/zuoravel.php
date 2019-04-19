<?php

return [
    'debug' => env('ZUORA_SANDBOX', false),

    'version' => env('ZUORA_VERSION', 'v1'),

    'client_id' => env('ZUORA_CLIENT_ID', ''),
    'client_secret' => env('ZUORA_CLIENT_SECRET', ''),

    'access_key' => env('ZUORA_ACCESS_KEY'), // apiAccessKeyId for UserAuth method
    'secret_access_key' => env('ZUORA_SECRET_ACCESS_KEY'), // apiSecretAccessKey for UserAuth method

    // Values are UserAuth or ClientAuth
    'authentication' => 'UserAuth',

    // Values are 'cache' or 'session'
    'storage' => 'cache',

    'entities' => [
        '2c92c0f966a9b7430166ad5141b404e1'
    ],

    'hostedPage' => [
        'apiSecurityKey' => env('ZUORA_API_SECURITY_KEY'),

        'tenantId' => '28102',

        'pageId' => '2c92c0f86a2f3322016a312559150781',

        'height' => 400,

        'width' => 700,

        'signatureMethod' => 'v2', // or v1

        'scriptVersion' => '1.3.1',

        'paymentGateway' => 'Cybersource Test Gateway'
    ]

];
