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

    // this is the first of the two methods defined in the PSR ContainerInterface.
    // The interface does not define a param type and so we are not able to either
    // due to the contravariance (remember that) rules that say parameter types are only able to become looser
    // thanks to covariance rules, we are able to add return type hints though
    public function get($id): object
    {
        // if we already have an instance stored, we just return that
        return $this->idsToInstances[$id]
            // otherwise we create an instance and store the result
            // note, the ==? null coalesce assignment operator, assigns the value of
            // the right hand side to the left when the left is null
            ??= $this->createInstance($id);
    }

    // this is the second of the two methods defined in the PSR ContainerInterface.
    public function has($id): bool
    {
        try {
            $this->getClassFullyQualifiedNameForId($id);

            return true;
        } catch (NotFoundExceptionInterface) {
            return false;
        }
    }

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
    private function getClassFullyQualifiedNameForId(string $id): string
    {
        if (array_key_exists($id, $this->idsToClassNames)) {
            // we return the fully qualified class name the service ID maps to
            return $this->idsToClassNames[$id];
        }
        throw new class('Failed finding service class for ' . $id) extends Exception implements NotFoundExceptionInterface {
        };
    }
}