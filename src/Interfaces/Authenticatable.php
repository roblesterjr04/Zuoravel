<?php

namespace Lester\Zuoravel\Interfaces;

use GuzzleHttp\Client;

interface Authenticatable
{

    public function authenticate(Client $client);

}
