<?php

namespace Lester\Zuoravel\Facades;

use Illuminate\Support\Facades\Facade;

class Zuora extends Facade
{
    protected static function getFacadeAccessor()
	{
		return 'zuora';
	}
}
