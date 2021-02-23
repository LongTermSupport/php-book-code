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

    // This is an array of class names to actual instances of that class.
    // This allows us to ensure we keep only one instance of a given class
    /** @var array <class-string, object|null> */
    private array $classNamesToInstances;

    private ServiceFactory $serviceFactory;

    public function __construct(ServiceDefinitionInterface ...$serviceDefinitions)
    {
        foreach ($serviceDefinitions as $serviceDefinition) {
            $this->storeDefinition($serviceDefinition);
        }
        $this->serviceFactory = new ServiceFactory(\array_keys($this->classNamesToInstances));
    }

    // this is the first of the two methods defined in the PSR ContainerInterface.
    // The interface does not define a param type and so we are not able to either
    // due to the contravariance (remember that) rules that say parameter types are only able to become looser
    // thanks to covariance rules, we are able to add return type hints though
    public function get($id): object
    {
        // first determine which class to use for the service ID
        $className = $this->getClassFullyQualifiedNameForId($id);

        // if we already have an instance stored, we just return that
        return $this->classNamesToInstances[$className]
            // otherwise we create an instance and store the result
            // note, the ==? null coalesce assignment operator, assigns the value of
            // the right hand side to the left when the left is null
            ??= $this->serviceFactory->createInstance($className);
    }

    // this is the second of the two methods defined in the PSR ContainerInterface.
    public function has($id): bool
    {
        return isset($this->idsToClassNames[$id]);
    }

    private function storeDefinition(ServiceDefinitionInterface $serviceDefinition): void
    {
        foreach ($serviceDefinition->getIds() as $id) {
            $className = $serviceDefinition->getClassFullyQualifiedName();

            // First we build a lookup between IDs to class names
            $this->idsToClassNames[$id] = $className;

            // Then we build an array with the key as class name and value as null,
            // ready to be replaced with an instance of the class on demand.
            // Note that this implicitly deduplicates classes that are defined with multiple IDs
            $this->classNamesToInstances[$className] = null;
        }
    }

    /**
     * @return class-string
     */
    private function getClassFullyQualifiedNameForId(string $id): string
    {
        return $this->idsToClassNames[$id]
               ??
               throw new class('Failed finding service class for ' . $id) extends Exception implements NotFoundExceptionInterface {
               };
    }
}
