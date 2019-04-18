<?php

namespace Lester\Zuoravel\Classes;

class Zuora
{

    private $client;
    private $hostedPage;

    /**
     * Instantiate the library class.
     */
    public function __construct()
    {
        $this->client = new ZuoraClient();
        $this->hostedPage = new ZuoraHostedPage();
    }

    public function test()
    {
        return $this->client->authenticate();
    }

    public function __call($method, $arguments)
    {
        if (count($arguments) == 1) {
            return $this->client->post($method, $arguments);
        } else {
            return $this->client->get($method);
        }
    }

    public function describe($object)
    {
        return $this->client->get('describe/'.$object);
    }

    public function iframe($id)
    {
        return $this->hostedPage->iframe($id);
    }
}
