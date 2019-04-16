<?php

return [
    'debug' => env('ZUORA_SANDBOX', false),

    'version' => env('ZUORA_VERSION', 'v1'),

    'client_id' => env('ZUORA_CLIENT_ID', ''),

    'client_secret' => env('ZUORA_CLIENT_SECRET', ''),

    // Values are user or client
    'authentication' => 'user',

    // Values are 'cache' or 'session'
    'storage' => 'cache',

    'entities' => [
        
    ],
];
