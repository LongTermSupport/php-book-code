<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI;

use Exception;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use RuntimeException;

final class Container implements ContainerInterface
{
    /** @var array<string, class-string> */
    private array $idsToClassNames;

    /** @var array <class-string, object|null> */
    private array $classNamesToInstances;

    public function __construct(ServiceDefinitionInterface ...$serviceDefinitions)
    {
        $this->idsToClassNames = [];
        foreach ($serviceDefinitions as $serviceDefinition) {
            $this->storeDefinition($serviceDefinition);
        }
    }

    /**
     * @param string $id
     *
     * @throws ReflectionException
     */
    // due to the PSR interface not defining types, we are not able to add a type here as that would break
    // remember the rules on Contravariance discussed in Chapter 2; parameter types can only get less specific
    public function get($id): object
    {
        $className = $this->getClassFullyQualifiedName($id);

        return $this->classNamesToInstances[$id]
            // null coalesce assignment operator, assigns the value of the right hand side to the left when the left is null
            ??= new $className(...$this->getDependencyInstances($className));
    }

    public function has($id): bool
    {
        try {
            $this->getClassFullyQualifiedName($id);

            return true;
        } catch (NotFoundExceptionInterface) {
            return false;
        }
    }

    private function storeDefinition(ServiceDefinitionInterface $serviceDefinition): void
    {
        foreach ($serviceDefinition->getIds() as $id) {
            $this->idsToClassNames[$id] = $serviceDefinition->getClassFullyQualifiedName();
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
            $return[] = $this->get($this->getServiceClassString($reflectionParameter));
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
                               ?? throw new RuntimeException('param is for a function, not a class');
            throw new RuntimeException(
                'Class ' . $classString . ' is a constructor dependency for ' .
                $reflectionClass->getShortName() . ' however it is not defined as a service'
            );
        }

        return $classString;
    }

    /**
     * @return class-string
     */
    private function getClassFullyQualifiedName(string $idOrClassName): string
    {
        if (array_key_exists($idOrClassName, $this->classNamesToInstances)) {
            return $idOrClassName;
        }
        if (array_key_exists($idOrClassName, $this->idsToClassNames)) {
            return $this->idsToClassNames[$idOrClassName];
        }
        throw new class('Failed finding service class for ' . $idOrClassName) extends Exception implements NotFoundExceptionInterface {
        };
    }
}
