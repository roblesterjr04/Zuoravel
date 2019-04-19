<?php

namespace Lester\Zuoravel\Classes;

use GuzzleHttp\Client;
use Lester\Zuoravel\Interfaces\Authenticatable;

class UserAuth implements Authenticatable
{
    public function authenticate(Client $client)
    {
        $client->post('connections', [
            'headers' => [
                'apiAccessKeyId' => config('zuoravel.access_key'),
                'apiSecretAccessKey' => config('zuoravel.secret_access_key'),
                'Zuora-Entity-Ids' => config('zuoravel.entities'),
            ]
        ]);
    }
}
