<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyServiceLocator;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use RuntimeException;

final class ServiceLocator
{
    /** @var array<class-string, class-string> */
    private array $interfacesToClasses;

    /** @var array <class-string, object|null> */
    private array $classNamesToInstances;

    public function __construct(ServiceDefinitionInterface ...$serviceDefinitions)
    {
        $this->interfacesToClasses = [];
        foreach ($serviceDefinitions as $serviceDefinition) {
            $this->storeDefinition($serviceDefinition);
        }
    }

    /**
     * @param class-string $interfaceName
     *
     * @throws ReflectionException
     */
    public function getInstance(string $interfaceName): object
    {
        $className = $this->getClassFullyQualifiedName($interfaceName);

        return $this->classNamesToInstances[$interfaceName] ??=
            new $className(...$this->getDependencyInstances($className));
    }

    private function storeDefinition(ServiceDefinitionInterface $serviceDefinition): void
    {
        foreach ($serviceDefinition->getInterfaceFullyQualifiedNames() as $interfaceFullyQualifiedName) {
            $this->interfacesToClasses[$interfaceFullyQualifiedName] = $serviceDefinition->getClassFullyQualifiedName();
        }
        $this->classNamesToInstances[$serviceDefinition->getClassFullyQualifiedName()] = null;
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
            $return[] = $this->getInstance($this->getServiceClassString($reflectionParameter));
        }

        return $return;
    }

    /**
     * @return class-string
     */
    private function getServiceClassString(ReflectionParameter $reflectionParameter): string
    {
        /** @var class-string $classString */
        $classString = (string)(
            $reflectionParameter->getType() ?? throw new RuntimeException('failed getting class string for type')
        );
        if (array_key_exists($classString, $this->classNamesToInstances) === false) {
            $reflectionClass = $reflectionParameter->getDeclaringClass()
                               ?? throw new RuntimeException('param is for a function not a class');
            throw new RuntimeException(
                'Class ' . $classString .
                ' is a constructor dependency for ' .
                $reflectionClass->getShortName() .
                ' however it is not defined as a service'
            );
        }

        return $classString;
    }

    /**
     * @param class-string $interfaceOrClassName
     *
     * @return class-string
     */
    private function getClassFullyQualifiedName(string $interfaceOrClassName): string
    {
        if (array_key_exists($interfaceOrClassName, $this->classNamesToInstances)) {
            return $interfaceOrClassName;
        }
        if (array_key_exists($interfaceOrClassName, $this->interfacesToClasses)) {
            return $this->interfacesToClasses[$interfaceOrClassName];
        }
        throw new RuntimeException('Failed finding service class for ' . $interfaceOrClassName);
    }
}
