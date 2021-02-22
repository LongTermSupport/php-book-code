<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\Controller\Data;

final class RequestData
{
    /**
     * @param array<string,string> $postData
     */
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

    /** @return array<string,string>|null */
    public function getPostData(): ?array
    {
        return $this->postData;
    }
}
