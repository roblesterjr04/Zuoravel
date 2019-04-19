<?php

namespace Lester\Zuoravel\Classes;

class Zuora
{

    private $client;

    /**
     * Instantiate the library class.
     */
    public function __construct()
    {
        $this->client = new ZuoraClient();
    }

    public function test()
    {
        return $this->client->authenticate();
    }

    public function __call($method, $arguments)
    {
        if (count($arguments) == 1) {
            return $this->client->post($method, $arguments);
        } else if (count($arguments) == 2) {
            return $this->client->put($method, $arguments);
        } else {
            return $this->client->get($method);
        }
    }

    public function getZuoraClient()
    {
        return $this->client;
    }

    public function catalog($productId = null)
    {
        if ($productId)
            return $this->client->get('catalog/product/' . $productId);

        return $this->client->get('catalog/products');
    }

    public function describe($object)
    {
        return $this->client->get('describe/'.$object);
    }

    public function paymentScreen($id = null, $tenantId = null)
    {
        $signingVersion = config('zuoravel.hostedPage.signatureMethod');
        switch ($signingVersion) {
            case 'v1':
                return (new PagesIframe($id, $tenantId))->screen();
                break;
            case 'v2':
                return (new PagesScript($id, $tenantId))->screen();
                break;
        }

    }

    public function iframeUrl($id = null, $tenantId = null)
    {
        return (new ZuoraHostedPage($id, $tenantId))->url();
    }

}
