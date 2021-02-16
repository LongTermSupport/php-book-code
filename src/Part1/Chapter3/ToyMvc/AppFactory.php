<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc;

use Book\Part1\Chapter3\ToyMvc\Controller\ControllerFactory;
use Book\Part1\Chapter3\ToyMvc\Controller\RequestDataFactory;

final class AppFactory
{
    public static function createFrontController(): FrontController
    {
        return new FrontController(
            new ControllerFactory(),
            new RequestDataFactory()
        );
    }
}