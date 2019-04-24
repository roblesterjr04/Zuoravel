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
        $restModel = $this->getRestModel($method);
        if ($restModel !== null) {
            if ($restModel->collectionOf) {
                return $restModel->all();
            }
            return $restModel->get(...$arguments);
        } else {
            // Pass generic calls to client.
            $this->client->$method(...$arguments);
        }
    }

    public function getZuoraClient()
    {
        return $this->client;
    }

    /*public function catalog($productId = null)
    {
        if ($productId)
            return $this->client->get('catalog/product/' . $productId);

        return $this->client->get('catalog/products');
    }*/

    public function describe($object)
    {
        return $this->client->get('describe/'.$object);
    }

    public function paymentScreen($id = null, $tenantId = null, $submit = true)
    {
        $signingVersion = config('zuoravel.hostedPage.signatureMethod');
        switch ($signingVersion) {
            case 'v1':
                return (new PagesIframe($id, $tenantId))->screen();
                break;
            case 'v2':
                return (new PagesScript($id, $tenantId, $submit))->screen();
                break;
        }

    }

    private function getRestModel($model, $options = [])
    {
        $model = 'Lester\\Zuoravel\\Models\\' . ucwords($model);
        if (!class_exists($model)) return null;
        return new $model($options);
    }

    public function iframeUrl($id = null, $tenantId = null)
    {
        return (new ZuoraHostedPage($id, $tenantId))->url();
    }

}
