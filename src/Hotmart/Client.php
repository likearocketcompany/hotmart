<?php

namespace LikeARocket\Hotmart;

use LikeARocket\Hotmart\HttpClient\HttpClient;

class Client
{
    public object $httpClient;

    public function __construct(string $url, string $accessToken)
    {
        $this->httpClient = new HttpClient($url, $accessToken);
    }

    public function get(string $endpoint, array $parameters = [], array $data = [])
    {
        return $this->httpClient->request($endpoint, 'GET', $parameters, $data);
    }

    public function post(string $endpoint, array $parameters = [], array $data = [])
    {
        return $this->httpClient->request($endpoint, 'POST', $parameters, $data);
    }

    public function patch(string $endpoint, array $parameters = [], array $data = [])
    {
        return $this->httpClient->request($endpoint, 'PATCH', $parameters, $data);
    }
}
