<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\Controller\Data;

final class Response
{
    /** @var ResponseHeader[] */
    private array $headers;

    public function __construct(private string $responseBody, ResponseHeader ...$headers)
    {
        $this->headers = $headers;
    }

    public function send(): void
    {
        array_map(static fn (ResponseHeader $header) => $header->send(), $this->headers);
        echo $this->responseBody;
    }
}
