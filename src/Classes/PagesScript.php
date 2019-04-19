<?php

namespace Lester\Zuoravel\Classes;

use Lester\Zuoravel\Interfaces\Signable;
use Lester\Zuoravel\Facades\Zuora;

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
        $version = config('zuoravel.hostedPage.scriptVersion', '1.3.1');
        $script = "<script type=\"text/javascript\" src=\"https://static.zuora.com/Resources/libs/hosted/$version/zuora-min.js\"></script>";
        $script .= "<div id=\"zuora_payment\"></div>
        <script>
            var zprepopulateFields = {};
            var zparams = {
                tenantId:'{$signature->tenantId}',
                id:'{$this->pageId()}',
                token:'{$signature->token}',
                signature:'{$signature->signature}',
                style:'inline',
                key:'{$signature->key}',
                submitEnabled:'true',
                locale:'{$this->locale()}',
                url:'{$this->baseUrl()}',
                paymentGateway:'{$this->paymentGateway()}'
            };
            var zcallback = function(response) {
                console.log(response);
            };
            Z.render(
                zparams,
                zprepopulateFields,
                zcallback
            );
        </script>";
        return $script;
    }

}
