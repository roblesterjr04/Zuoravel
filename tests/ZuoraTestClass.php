<?php

namespace Lester\Zuoravel\Tests;

use Lester\Zuoravel\ServiceProvider;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Config;

class ZuoraTestClass extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function testIframeSignature()
    {

    }
}
