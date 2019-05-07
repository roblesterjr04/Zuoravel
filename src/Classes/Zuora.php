<?php

namespace Lester\Zuoravel\Classes;

class Zuora
{

    private $client;
    private $entity;

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
                return $restModel->all(...$arguments);
            }
            if (!count($arguments)) return $restModel;
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

    public function entity($entityId = null)
    {
        if ($entityId) {
            $this->client = new ZuoraClient([$entityId]);
            $this->entity = $entityId;
            return $this;
        }

        return $this->client->get('entities/' . $this->entity);
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
