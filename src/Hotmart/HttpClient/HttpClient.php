<?php

namespace LikeARocket\Hotmart\HttpClient;

use Exception;

class HttpClient
{
    protected string $url;
    protected string $accessToken;
    protected string $method;
    protected array $headers;
    protected array $parameters;
    protected string $body = '';
    private object $request;
    private object $response;
    private object $ch;

    public function __construct(string $url, string $accessToken)
    {
        if (! function_exists('curl_version')) {
            throw new Exception('cURL is NOT installed on this server');
        }

        $this->url = $this->buildApiUrl($url);
        $this->accessToken = $this->buildApiAccessToken($accessToken);
    }

    protected function buildApiUrl(string $url): string
    {
        if (! str_ends_with($url, '/')) {
            return $url . '/';
        }

        return $url;
    }

    protected function buildApiAccessToken(string $accessToken): string
    {
        if (! str_starts_with($accessToken, 'Bearer ')) {
            return 'Bearer ' . $accessToken;
        }

        return $accessToken;
    }

    protected function buildUrlQuery(string $url, array $parameters): string
    {
        if (! empty($parameters)) {
            foreach($parameters as $key => $parameter) {
                if (! is_array($parameter)) {
                    if (false !== strpos($url, '?')) {
                        $url .= '&' . http_build_query([$key => $parameter]);
                    } else {
                        $url .= '?' . http_build_query([$key => $parameter]);
                    }
                } else {
                    foreach($parameter as $param) {
                        if (false !== strpos($url, '?')) {
                            $url .= '&' . http_build_query([$key => $param]);
                        } else {
                            $url .= '?' . http_build_query([$key => $param]);
                        }
                    }
                }
            }
        }

        return $url;
    }

    protected function setMethod(string $method): void
    {
        $this->method = $method;
    }

    protected function setHeaders(): void
    {
        $this->headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: ' . $this->accessToken,
        ];
    }

    protected function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    protected function setBody(array $data): void
    {
        $this->body = json_encode($data);
    }

    protected function setDefaultCurlSettings(): void
    {
        curl_setopt($this->ch, CURLOPT_URL, $this->request->getUrl());
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->request->getMethod());
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->request->getHeaders());
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        if (in_array($this->method, ['POST', 'PATCH']) && ! empty($this->body)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->body);
        }
    }

    protected function createRequest(string $endpoint, string $method, array $parameters = [], array $data = []): Request
    {
        if (str_starts_with($endpoint, '/')) {
            $endpoint = ltrim($endpoint, '/');
        }

        $url = $this->url . $endpoint;
        $this->setMethod($method);
        $this->setHeaders();
        $this->setParameters($parameters);

        if (! empty($data)) {
            $this->setBody($data);
        }

        $this->request = new Request($this->buildUrlQuery($url, $this->parameters), $this->method, $this->headers, $this->parameters, $this->body);

        $this->setDefaultCurlSettings();

        return $this->request;
    }

    protected function createResponse(): void
    {
        $body = curl_exec($this->ch);
        $code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        $this->response = new Response($code, [], $body);
    }

    public function request(string $endpoint, string $method, array $parameters = [], array $data = [])
    {
        $this->ch = curl_init();

        $request = $this->createRequest($endpoint, $method, $parameters, $data);

        $this->createResponse();

        if (curl_errno($this->ch)) {
            throw new Exception('cURL Error: ' . curl_error($this->ch));
        }

        curl_close($this->ch);

        $response = json_decode($this->response->getBody(), true);

        return $response;
    }
}
