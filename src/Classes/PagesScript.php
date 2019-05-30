<?php

namespace Lester\Zuoravel\Classes;

use Lester\Zuoravel\Interfaces\Signable;
use Lester\Zuoravel\Facades\Zuora;
use Illuminate\Support\Arr;

class PagesScript extends ZuoraHostedPage implements Signable
{

    public function sign($data = [])
    {
        $client = Zuora::getZuoraClient();

        $response = $client->post('rsa-signatures', $data);

        return $response;

    }

    public function screen($data = [])
    {
        $signature = $this->signature();
        $submit = $this->submit ? 'true' : 'false';

        $defaults = [
            'tenantId'  => $signature->tenantId,
            'id'        => $this->pageId(),
            'token'     => $signature->token,
            'signature' => $signature->signature,
            'style'     => 'inline',
            'key'       => $signature->key,
            'submitEnabled' => $submit,
            'locale'    => $this->locale(),
            'url'       => $this->baseUrl(),
            'paymentGateway' => $this->paymentGateway(),
        ];

        $options = array_merge($defaults, Arr::get($data, 'parameters') ?: []);
        $prefill = Arr::get($data, 'prepopulateField') ?: [];

        $optionsJson = json_encode($options);
        $prefillJson = json_encode($prefill);


        $version = config('zuoravel.hostedPage.scriptVersion', '1.3.1');
        $script = "<script type=\"text/javascript\" src=\"https://static.zuora.com/Resources/libs/hosted/$version/zuora-min.js\"></script>";
        $script .= "<div id=\"zuora_payment\"></div>
        <script>
            function zuoraRenderPage() {
                var zprepopulateFields = {$prefillJson};
                var zparams = {$optionsJson};
                var zerrorHandler = function(key, code, message) {
                    console.log(key, code, message);
                    {$this->errorHandler}(key, message);
                };
                var zcallback = function(response) {
                    console.log(response);
                    {$this->callback}(response);
                };
                Z.renderWithErrorHandler(
                    zparams,
                    zprepopulateFields,
                    zcallback,
                    zerrorHandler
                );
            }
            zuoraRenderPage();
        </script>";
        return $script;
    }

}
