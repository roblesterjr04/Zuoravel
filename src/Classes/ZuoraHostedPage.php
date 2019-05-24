<?php

namespace Lester\Zuoravel\Classes;

use Lester\Zuoravel\Interfaces\PagesSignature;

abstract class ZuoraHostedPage
{

    private $pageId;
    private $tenantId;
    private $pageModel;
    protected $errorHandler;
    protected $submit;
    protected $callback;

    public function __construct($pageId = null, $tenantId = null, $submit = true, $callback = 'zuoraCallback', $errorHandler = 'zuoraErrorHandler')
    {
        $this->pageId = $pageId;
        $this->tenantId = $tenantId;
        $this->submit = $submit;
        $this->callback = $callback;
        $this->errorHandler = $errorHandler;
    }


    protected function locale()
    {
        return config('zuoravel.hostedPage.locale', 'en_US');
    }

    public function url() {
        return $this->pageUrl();
    }

    protected function iframeId()
    {
        return config('zuoravel.hostedPage.iframeId', 'z_hppm_iframe');
    }

    private function pageUrl()
    {
        return "{$this->baseUrl()}?method=requestPage&{$this->queryString()}&signature={$this->signature()}";
    }

    protected function baseUrl()
    {
        return "{$this->domain()}/PublicHostedPageLite.do";
    }

    protected function pageId()
    {
        return $this->pageId ?: config('zuoravel.hostedPage.pageId');
    }

    protected function tenantId()
    {
        return $this->tenantId ?: config('zuoravel.hostedPage.tenantId');
    }

    protected function timestamp()
    {
        return round(microtime(true) * 1000);
    }

    protected function domain()
    {
        return config('zuoravel.debug') ? 'https://apisandbox.zuora.com/apps' : 'https://api.zuora.com/apps';
    }

    protected function token()
    {
        return str_random(32);
    }

    protected function apiSecurityKey()
    {
        return config('zuoravel.hostedPage.apiSecurityKey');
    }

    protected function queryString()
    {
        $queryArray = [
            'id'        => $this->pageId(),
            'tenantId'  => $this->tenantId(),
            'timestamp' => $this->timestamp(),
            'token'     => $this->token(),
        ];

        return http_build_query($queryArray);
    }

    protected function signature()
    {
        return $this->sign([
            'uri' => $this->baseUrl(),
            'pageId' => $this->pageId(),
            'method' => 'POST'
        ]);
    }

    protected function paymentGateway()
    {
        return config('zuoravel.hostedPage.paymentGateway');
    }

}
