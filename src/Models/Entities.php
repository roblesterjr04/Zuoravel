<?php

namespace Lester\Zuoravel\Models;

use Lester\Zuoravel\Models\RestModel;
use Lester\Zuoravel\Interfaces\Restable;

class Entities extends RestModel implements Restable
{

    protected $object = 'entities';
    public $collectionOf = \Lester\Zuoravel\Models\Entity::class;

}
