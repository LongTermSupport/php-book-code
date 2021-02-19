<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyServiceLocator;

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

    private function storeDefinition(ServiceDefinitionInterface $serviceDefinition): void
    {
        foreach ($serviceDefinition->getInterfaceFullyQualifiedNames() as $interfaceFullyQualifiedName) {
            $this->interfacesToClasses[$interfaceFullyQualifiedName] = $serviceDefinition->getClassFullyQualifiedName();
        }
        $this->classNamesToInstances[$serviceDefinition->getClassFullyQualifiedName()] = null;
    }

    public function getInstance(string $interfaceName): object
    {
        $className = $this->getClassFullyQualifiedName($interfaceName);

        return $this->interfacesToClasses[$interfaceName] ?? $this->createInstance($className);
    }

    private function createInstance(string $className): object
    {
        return new $className(...$this->getDependencyInstances($className));
    }


    private function getDependencyInstances(string $className): array
    {
        $return = [];
        foreach ((new \ReflectionClass($className))->getConstructor()->getParameters() as $reflectionParameter) {
            $return[] = $this->getInstance($this->getServiceClassString($reflectionParameter));
        }

        return $return;
    }

    private function getServiceClassString(\ReflectionParameter $reflectionParameter): string
    {
        $classString = (string)$reflectionParameter->getType();
        if (false === array_key_exists($classString, $this->classNamesToInstances)) {
            throw new \RuntimeException(
                'Class ' . $classString .
                ' is a constructor dependency for ' .
                $reflectionParameter->getDeclaringClass()->getShortName() .
                ' however it is not defined as a service'
            );
        }

        return $classString;
    }

    private function getClassFullyQualifiedName(string $interfaceOrClassName): string
    {
        if (array_key_exists($interfaceOrClassName, $this->classNamesToInstances)) {
            return $interfaceOrClassName;
        }
        if (array_key_exists($interfaceOrClassName, $this->interfacesToClasses)) {
            return $this->interfacesToClasses[$interfaceOrClassName];
        }
        throw new \RuntimeException('Failed finding service class for ' . $interfaceOrClassName);
    }
}