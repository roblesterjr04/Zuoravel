<?php

namespace Lester\Zuoravel\Models;

use Lester\Zuoravel\Models\RestModel;
use Lester\Zuoravel\Models\Invoice;
use Lester\Zuoravel\Interfaces\Restable;
use Lester\Zuoravel\Facades\Zuora;
use Illuminate\Support\Arr;

class Subscription extends RestModel implements Restable
{

    protected $object = 'subscriptions';

    protected $appends = [
        'invoice',
    ];

    public function preview($payload = [])
    {
        $response = Zuora::getZuoraClient()->post('subscriptions/preview', $payload);

        return new self((array)$response);
    }

    public function getInvoiceAttribute()
    {
        return new Invoice((array)Arr::get($this->attributes, 'invoice'));
    }

}
