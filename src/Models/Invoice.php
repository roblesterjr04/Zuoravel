<?php

namespace Lester\Zuoravel\Models;

use Lester\Zuoravel\Models\RestModel;
use Lester\Zuoravel\Interfaces\Restable;
use Lester\Zuoravel\Facades\Zuora;

class Invoice extends RestModel implements Restable
{

    protected $object = 'invoices';

}
