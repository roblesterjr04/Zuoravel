<?php

namespace Lester\Zuoravel\Classes;

use Lester\Zuoravel\Interfaces\Signable;

class PagesIframe extends ZuoraHostedPage implements Signable
{
    public function sign($data = [])
    {
        $queryString = $this->queryString() . $this->apiSecurityKey();

        $utf8String = utf8_encode($queryString);

        $hashString = md5($utf8String);

        return strtr(base64_encode($hashString), '+/', '-_');
    }

    public function screen($data = [])
    {
        $width = $width ?: config('zuoravel.hostedPage.width', 630);
        $height = $height ?: config('zuoravel.hostedPage.height', 220);
        return "<iframe frameborder=\"0\" src=\"{$this->pageUrl()}\" id=\"{$this->iframeId()}\" width=\"{$width}\" height=\"{$height}\"></iframe>";
    }
}
