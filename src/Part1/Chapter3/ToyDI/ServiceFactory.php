<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use RuntimeException;

final class ServiceFactory
{
    /** @param array<int, class-string> $serviceClassNames */
    public function __construct(private array $serviceClassNames)
    {
    }

    /** @param class-string $className */
    public function get(string $className): object
    {
        $this->assertServiceClassName($className);

        return new $className(...$this->getDependencyInstances($className));
    }

    private function assertServiceClassName(string $className): void
    {
        if (in_array($className, $this->serviceClassNames, strict: true) === true) {
            return;
        }
        throw new RuntimeException(
            'Class ' . $className . ' is not defined as a service'
        );
    }

    /**
     * @param class-string $className
     *
     * @throws ReflectionException
     *
     * @return array<int,object>
     */
    private function getDependencyInstances(string $className): array
    {
        $return      = [];
        $constructor = (new ReflectionClass($className))->getConstructor();
        if ($constructor === null) {
            throw new InvalidArgumentException("{$className} does not have a constructor");
        }
        foreach ($constructor->getParameters() as $reflectionParameter) {
            $return[] = $this->get($this->getServiceClassString($reflectionParameter));
        }

        return $return;
    }

    /**
     * @return class-string
     */
    private function getServiceClassString(ReflectionParameter $reflectionParameter): string
    {
        return (string)(
            $reflectionParameter->getType() ?? throw new RuntimeException('failed getting class string for type')
        );
    }
}
