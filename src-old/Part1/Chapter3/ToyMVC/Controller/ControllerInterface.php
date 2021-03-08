<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\Controller;

use Book\Part1\Chapter3\ToyMVC\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMVC\Controller\Data\Response;

interface ControllerInterface
{
    public function getResponse(RequestData $requestData): Response;
}
