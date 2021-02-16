<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Error\NotFoundController;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

final class ControllerFactory
{
    /**
     * Here we have an array of controller FQNs.
     * These represent the controllers that we will
     * check for matching a given set of RequestData
     *
     * @see https://phpstan.org/writing-php-code/phpdoc-types#class-string
     *
     * @var array<int, class-string<ControllerInterface>>|ControllerInterface[]
     */
    private const CONTROLLERS = [
        HomePageController::class,
        CategoryPageController::class,
        PostPageController::class,
    ];

    /**
     * This method will take a set of RequestData and will then
     * check all of the Controllers to see if one matches.
     *
     * To handle the matching, we are using a Route attribute
     * which includes a regex pattern to test against the request URI.
     *
     * If we find a matching controller then we create that controller
     * using it's static create method
     *
     * @throws ReflectionException
     */
    public function createControllerForRequest(RequestData $requestData): ControllerInterface
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