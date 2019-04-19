<?php

namespace Lester\Zuoravel\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Lester\Zuoravel\Interfaces\Authenticatable;

class ClientAuth implements Authenticatable
{
    public function authenticate(Client $client)
    {
        $url = config('zuoravel.debug') ? 'https://rest.apisandbox.zuora.com' : 'https://rest.api.zuora.com';

        $response = $client->post($url . '/oauth/token', [
            'form_params' => [
                'client_id' => config('zuoravel.client_id'),
                'client_secret' => config('zuoravel.client_secret'),
                'grant_type' => config('zuoravel.grant_type', 'client_credentials')
            ]
        ]);

        $body = json_decode($response->getBody());

        $storage = ucwords(config('zuoravel.storage', 'cache'));

        $storage::put('_zuoravel_token', $body, now()->addSeconds($body->expires_in));

        return $body;
    }
}
