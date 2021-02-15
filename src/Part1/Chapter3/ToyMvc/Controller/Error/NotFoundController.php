<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller\Error;

use Book\Part1\Chapter3\ToyMvc\Controller\ControllerInterface;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\Response;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\ResponseHeader;

final class NotFoundController implements ControllerInterface
{
    public function getResponse(RequestData $requestData): Response
    {
        return new Response(responseBody: '404 Nothing Found', headers: new ResponseHeader('404 nothing found', 404));
    }

    /** @param array<mixed,string> $uriMatches */
    public static function create(array $uriMatches): static
    {
        return new self();
    }
}
