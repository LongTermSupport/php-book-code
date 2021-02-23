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
    /**
     * A fast lookup array for validating class names.
     *
     * @var array<class-string, bool>
     */
    private array $classLookup;

    /** @param array<int, class-string> $classNames */
    public function __construct(array $classNames)
    {
        $this->buildClassLookup($classNames);
    }

    /** @param class-string $className */
    public function createInstance(string $className): object
    {
        $this->assertServiceClassName($className);

        return new $className(...$this->getDependencyInstances($className));
    }

    /**
     * This method builds up an optimised lookup array so that we can validate valid class names.
     *
     * @param array<int, class-string> $classNames
     */
    private function buildClassLookup(array $classNames): void
    {
        $uniqueClasses     = \array_unique($classNames);
        $this->classLookup = \array_fill_keys(keys: $uniqueClasses, value: true);
    }

    private function assertServiceClassName(string $className): void
    {
        if (isset($this->classLookup[$className])) {
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
            $return[] = $this->createInstance($this->getServiceClassString($reflectionParameter));
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
