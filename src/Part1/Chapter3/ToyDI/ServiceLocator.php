<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class ServiceLocator implements ContainerInterface
{
    // This is an array of service IDs to the class name configured for the service
    /** @var array<string, class-string> */
    private array $idsToClassNames;

    // This is an array of ids to actual instances
    /** @var array <string, object|null> */
    private array $idsToInstances;

    private ServiceFactory $serviceFactory;

    public function __construct(ServiceDefinitionInterface ...$serviceDefinitions)
    {
        foreach ($serviceDefinitions as $serviceDefinition) {
            $this->storeDefinition($serviceDefinition);
        }
        $this->serviceFactory = new ServiceFactory(array_values(array_unique($this->idsToClassNames)));
    }

    public function get($id): object
    {
        // if we already have an instance stored, we just return that
        return $this->idsToInstances[$id]
            // otherwise we create an instance and store the result
            // note, the ==? null coalesce assignment operator, assigns the value of
            // the right hand side to the left when the left is null
            ??= $this->createInstance($id);
    }

    public function has($id): bool
    {
        try {
            $this->getClassFullyQualifiedNameForId($id);

            return true;
        } catch (NotFoundExceptionInterface) {
            return false;
        }
    }

    // due to the PSR interface not defining types, we are not able to add a type here as that would break
    // remember the rules on Contravariance discussed in Chapter 2; parameter types can only get less specific
    private function storeDefinition(ServiceDefinitionInterface $serviceDefinition): void
    {
        foreach ($serviceDefinition->getIds() as $id) {
            $className                  = $serviceDefinition->getClassFullyQualifiedName();
            $this->idsToClassNames[$id] = $className;
            $this->idsToInstances[$id]  = null;
        }
    }

    private function createInstance(string $id): object
    {
        $className = $this->getClassFullyQualifiedNameForId($id);

        return $this->serviceFactory->createInstance($className);
    }

    /**
     * @return class-string
     */
    private function getClassFullyQualifiedNameForId(string $idOrClassName): string
    {
        if (array_key_exists($idOrClassName, $this->idsToClassNames)) {
            // we return the fully qualified class name the service ID maps to
            return $this->idsToClassNames[$idOrClassName];
        }
        throw new class('Failed finding service class for ' . $idOrClassName) extends Exception implements NotFoundExceptionInterface {
        };
    }
}
