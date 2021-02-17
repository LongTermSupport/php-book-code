<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc;

use Book\Part1\Chapter3\ToyMvc\Controller\Factory\ControllerFactory;
use Book\Part1\Chapter3\ToyMvc\Controller\Factory\RequestDataFactory;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\CategoryRepository;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\PostRepository;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;

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
