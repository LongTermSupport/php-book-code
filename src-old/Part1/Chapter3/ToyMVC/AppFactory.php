<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC;

use Book\Part1\Chapter3\ToyMVC\Controller\Factory\ControllerFactory;
use Book\Part1\Chapter3\ToyMVC\Controller\Factory\RequestDataFactory;
use Book\Part1\Chapter3\ToyMVC\Model\Repository\CategoryRepository;
use Book\Part1\Chapter3\ToyMVC\Model\Repository\PostRepository;
use Book\Part1\Chapter3\ToyMVC\View\TemplateRenderer;

final class AppFactory
{
    public static function createFrontController(): FrontController
    {
        return new FrontController(
            new ControllerFactory(
                new CategoryRepository(),
                new PostRepository(),
                new TemplateRenderer()
            ),
            new RequestDataFactory()
        );
    }
}
