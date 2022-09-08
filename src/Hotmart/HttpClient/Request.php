<?php

namespace LikeARocket\Hotmart\HttpClient;

class Request
{
    private string $url;
    private string $method;
    private array $headers;
    private array $parameters;
    private string $body;

    public function __construct(string $url = '', string  $method = '', array $headers = [], array $parameters = [], string $body = '')
    {
        $this->url = $url;
        $this->method = $method;
        $this->headers = $headers;
        $this->parameters = $parameters;
        $this->body = $body;
    }
    
    public function setUrl($url): void
    {
        $this->url = $url;
    }
    
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    public function setParameters($parameters): void
    {
        $this->parameters = $parameters;
    }

    public function setHeaders($headers): void
    {
        $this->headers = $headers;
    }

    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
