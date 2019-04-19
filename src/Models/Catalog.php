<?php

namespace Lester\Zuoravel\Models;

use Lester\Zuoravel\Models\RestModel;
use Lester\Zuoravel\Interfaces\Restable;

class Catalog extends RestModel implements Restable
{

    protected $object = 'catalog/products';
    public $collectionOf = \Lester\Zuoravel\Models\Product::class;


}
