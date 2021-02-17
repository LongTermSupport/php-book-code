<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Meta;

use Attribute;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;

#[Attribute]
final class Route
{
    /** @var RequestMethod[] */
    private array $methods;

    public function __construct(private string $routePattern, string ...$methods)
    {
        $this->methods = array_map(
            callback: static function (string $method): RequestMethod {
                return new RequestMethod($method);
            },
            array: $methods
        );
    }

    public function isMatch(RequestData $requestData): bool
    {
        return $this->matchesMethod($requestData) && $this->matchesRoutePattern($requestData);
    }

    private function matchesRoutePattern(RequestData $requestData): bool
    {
        return preg_match($this->routePattern, $requestData->getUri()) === 1;
    }

    private function matchesMethod(RequestData $requestData): bool
    {
        foreach ($this->methods as $method) {
            if ($method->getName() === $requestData->getMethod()->getName()) {
                return true;
            }
        }

        return false;
    }
}
