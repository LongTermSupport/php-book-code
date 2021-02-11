<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller\Data;

class RequestData
{
    public function __construct(
        private string $uri,
        private RequestMethod $method,
        private ?array $postData = null,
    ) {

    }

    public function getMethod(): RequestMethod
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getPostData(): array
    {
        return $this->postData;
    }
}