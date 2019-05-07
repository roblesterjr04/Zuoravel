<?php

namespace Lester\Zuoravel\Models;

use Lester\Zuoravel\Models\RestModel;
use Lester\Zuoravel\Interfaces\Restable;

class ProductRatePlan extends RestModel implements Restable
{

    protected $object = 'object/product-rate-plan';

}
