<?php

namespace Lester\Zuoravel\Models;

use Lester\Zuoravel\Models\RestModel;
use Lester\Zuoravel\Interfaces\Restable;
use Lester\Zuoravel\Facades\Zuora;

class Subscription extends RestModel implements Restable
{

    protected $object = 'subscriptions';

    public function preview($payload = [])
    {
        $response = Zuora::getZuoraClient()->post('subscriptions/preview', $payload);

        return $response;
    }

}
