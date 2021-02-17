<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller\Factory;

use Book\Part1\Chapter3\ToyMvc\Controller\CategoryPageController;
use Book\Part1\Chapter3\ToyMvc\Controller\ControllerInterface;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Error\NotFoundController;
use Book\Part1\Chapter3\ToyMvc\Controller\HomePageController;
use Book\Part1\Chapter3\ToyMvc\Controller\PostPageController;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\CategoryRepository;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\PostRepository;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

final class ControllerFactory
{
    /**
     * Here we have an array of controller FQNs.
     * These represent the controllers that we will
     * check for matching a given set of RequestData.
     *
     * @see https://phpstan.org/writing-php-code/phpdoc-types#class-string
     *
     * @var array<int, class-string<ControllerInterface>>
     */
    private const CONTROLLERS = [
        HomePageController::class,
        CategoryPageController::class,
        PostPageController::class,
    ];

    public function __construct(
        private CategoryRepository $categoryRepository,
        private PostRepository $postRepository,
        private TemplateRenderer $templateRenderer
    ) {
    }

    /**
     * This method will take a set of RequestData and will then
     * check all of the Controllers to see if one matches.
     *
     * To handle the matching, we are using a Route attribute
     * which includes a regex pattern to test against the request URI.
     *
     * If we find a matching controller then we create that controller
     *
     * @throws ReflectionException
     */
    public function createControllerForRequest(RequestData $requestData): ControllerInterface
    {
        foreach (self::CONTROLLERS as $controllerFqn) {
            $route = $this->getRoute($controllerFqn);
            if ($route->isMatch($requestData)) {
                return match ($controllerFqn) {
                    HomePageController::class     => $this->createHomePageController(),
                    CategoryPageController::class => $this->createCategoryPageController(),
                    PostPageController::class     => $this->createPostPageController(),
                };
            }
        }

        return $this->createNotFoundController();
    }

    private function createNotFoundController(): NotFoundController
    {
        return new NotFoundController($this->templateRenderer);
    }

    private function createHomePageController(): HomePageController
    {
        return new HomePageController($this->categoryRepository, $this->templateRenderer);
    }

    private function createCategoryPageController(): CategoryPageController
    {
        return new CategoryPageController($this->categoryRepository, $this->templateRenderer);
    }

    private function createPostPageController(): PostPageController
    {
        return new PostPageController($this->postRepository, $this->templateRenderer);
    }

    /**
     * @param class-string<ControllerInterface> $controllerFqn
     *
     * @throws ReflectionException
     */
    private function getRoute(string $controllerFqn): Route
    {
        $route = (new ReflectionClass($controllerFqn))->getAttributes(Route::class)[0]->newInstance();
        if ($route instanceof Route) {
            return $route;
        }
        throw new InvalidArgumentException(
            'Controller ' . $controllerFqn . ' does not have a Route attribute'
        );
    }
}
