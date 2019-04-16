<?php

namespace Lester\Zuoravel\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;

use Mtownsend\XmlToArray\XmlToArray;

class ZuoraClient
{
    private $client;
    private $cookies = [];

    public function __construct()
    {
        $url = config('zuoravel.debug') ? 'https://rest.apisandbox.zuora.com' : 'https://rest.api.zuora.com';
        $version = config('zuoravel.version');

        $this->client = new Client([
            'base_uri' => "$url/$version/",
            'cookies' => true,
            'http_errors' => true,
        ]);
    }

    private function tokenStorage()
    {
        return ucwords(config('zuoravel.storage', 'cache'));
    }

    public function authenticate()
    {
        $response = $this->client->post('connections', [
            'headers' => [
                'apiAccessKeyId' => config('zuoravel.client_id'),
                'apiSecretAccessKey' => config('zuoravel.client_secret')
            ]
        ]);
    }

    public function __call($method, $arguments)
    {
        return $this->request($method, ...$arguments);
    }

    private function request($method, $endpoint, $arguments)
    {
        try {
            $response = $this->client->$method($endpoint, [
                'json' => $arguments
            ]);
        } catch (ClientException $e) {
            $this->authenticate();
            return $this->request($method, $endpoint, $arguments);
        }

        return $this->parseResponse($response);
    }

    private function parseResponse($response)
    {
        $contentType = str_before($response->getHeader('Content-Type')[0], ';');
        switch ($contentType) {
            case 'text/xml':
                return json_decode(json_encode(XmlToArray::convert((string)$response->getBody())));
                break;
            case 'application/json':
                return json_decode($response->getBody());
                break;
            default:
                return (string)$response->getbody();
        }
        return null;
    }


}
