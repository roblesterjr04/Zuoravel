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
    private $authMethod;
    private $entities;

    public function __construct($entities = null)
    {
        $url = config('zuoravel.debug') ? 'https://rest.apisandbox.zuora.com' : 'https://rest.api.zuora.com';
        $version = config('zuoravel.version');
        $authMethod = 'Lester\\Zuoravel\\Classes\\' . config('zuoravel.authentication');
        $this->authMethod = new $authMethod();
        $this->entities = $entities ?: config('zuoravel.entities');

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
        return $this->authMethod->authenticate($this->client);
    }

    public function __call($method, $arguments = [])
    {
        return $this->request($method, ...$arguments);
    }

    private function request($method, $endpoint, $arguments = [], $query = [])
    {
        try {
            $payload = [
                'json' => $arguments,
                'query' => $query,
            ];
            $storage = $this->tokenStorage();
            if (config('zuoravel.authentication') == 'ClientAuth') {
                $payload['headers'] = [
                    'Authorization' => 'Bearer ' . $storage::get('_zuoravel_token', $this->authenticate())->access_token,
                    'Zuora-Entity-Ids' => $this->entities,
                ];
            }
            $response = $this->client->$method($endpoint, $payload);
        } catch (ClientException $e) {
            //throw($e);
            //sleep(1);
            //$this->authenticate();
            return $this->request($method, $endpoint, $arguments, $query);
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
