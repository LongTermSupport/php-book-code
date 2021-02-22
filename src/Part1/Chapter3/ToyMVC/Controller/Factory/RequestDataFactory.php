<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\Controller\Factory;

use Book\Part1\Chapter3\ToyMVC\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMVC\Controller\Data\RequestMethod;

final class RequestDataFactory
{
    public static function createFromGlobals(): RequestData
    {
        return new RequestData(
            $_SERVER['REQUEST_URI'],
            new RequestMethod($_SERVER['REQUEST_METHOD'])
        );
    }
}
