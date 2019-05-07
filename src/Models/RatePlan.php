<?php

namespace Lester\Zuoravel\Models;

use Lester\Zuoravel\Models\RestModel;
use Lester\Zuoravel\Interfaces\Restable;

class RatePlan extends RestModel implements Restable
{

    protected $object = 'object/rate-plan';

}
