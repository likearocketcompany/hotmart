<?php

namespace LikeARocket\Hotmart\HttpClient;

class Response
{
    
    private int $code;
    private array $headers;
    private string $body;

    public function __construct(int $code = 0, array $headers = [], string $body = '')
    {
        $this->code = $code;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function setCode(int $code): void
    {
        $this->code = (int) $code;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getCode(): int
    {
        return $this->code;
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
