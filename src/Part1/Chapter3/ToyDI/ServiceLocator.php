<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

final class ServiceLocator implements ContainerInterface
{
    /** @var array<string, class-string> */
    private array $idsToClassNames;

    /** @var array <class-string, object|null> */
    private array          $classNamesToInstances;
    private ServiceFactory $builder;

    public function __construct(ServiceDefinitionInterface ...$serviceDefinitions)
    {
        $this->idsToClassNames = [];
        foreach ($serviceDefinitions as $serviceDefinition) {
            $this->storeDefinition($serviceDefinition);
        }
        $this->builder = new ServiceFactory(array_keys($this->classNamesToInstances));
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
            ??= $this->builder->get($className);
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
