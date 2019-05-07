<?php

namespace Lester\Zuoravel\Models;

use Lester\Zuoravel\Models\RestModel;
use Lester\Zuoravel\Interfaces\Restable;

class Catalog extends RestModel implements Restable
{

    protected $object = 'catalog/products';
    public $collectionOf = \Lester\Zuoravel\Models\Product::class;

    public static function get($id)
    {
        $parent = parent::get($id);
        $me = new static();
        $model = $me->collectionOf;
        return new $model($parent->toArray());
    }
}
