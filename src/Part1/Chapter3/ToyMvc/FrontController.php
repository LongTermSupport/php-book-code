<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc;

use Book\Part1\Chapter3\ToyMvc\Controller\CategoryPageController;
use Book\Part1\Chapter3\ToyMvc\Controller\ControllerInterface;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Error\NotFoundController;
use Book\Part1\Chapter3\ToyMvc\Controller\HomePageController;
use Book\Part1\Chapter3\ToyMvc\Controller\PostPageController;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

final class FrontController
{
    /**
     * @see https://phpstan.org/writing-php-code/phpdoc-types#class-string
     *
     * @var array<int, class-string<ControllerInterface>>|ControllerInterface[]
     */
    private const CONTROLLERS = [
        HomePageController::class,
        CategoryPageController::class,
        PostPageController::class,
    ];

    public function getController(RequestData $requestData): ControllerInterface
    {
        foreach (self::CONTROLLERS as $controllerFqn) {
            $route = $this->getRoute($controllerFqn);
            if ($route->isMatch($requestData)) {
                return $controllerFqn::create($route->getMatchGroups());
            }
        }

        return NotFoundController::create([]);
    }

    /**
     * @param class-string $controllerFqn
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
