<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\Response;

interface ControllerInterface
{
    public function getResponse(RequestData $requestData): Response;

    /** @param array<mixed,string> $uriMatches */
    public static function create(array $uriMatches): static;
}
