<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Meta;

use Attribute;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;

#[Attribute]
class Route
{
    /** @var RequestMethod[] */
    private array $methods;
    /** @var string[]|null */
    private ?array $matchesCache;

    public function __construct(private string $routePattern, string ...$methods)
    {
        $this->methods = array_map(
            callback: static function (string $method) {
            return new RequestMethod($method);
        },
            array: $methods
        );
    }

    public function isMatch(RequestData $requestData): bool
    {
        if (false === in_array($requestData->getMethod(), $this->methods, true)) {
            return false;
        }

        return 1 === preg_match($this->routePattern, $requestData->getUri(), $this->matchesCache);
    }

    /** @return string[] */
    public function getMatchGroups(): array
    {
        return $this->matchesCache ??
               throw new \RuntimeException('calling getMatchGroups before isMatch is not supported');
    }
}