<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI;

class SimpleServiceDefinition implements ServiceDefinitionInterface
{
    /**
     * @param class-string $id
     * @param class-string $className
     */
    public function __construct(
        private string $id,
        private string $className
    ) {
    }

    /** @return array<int,class-string> */
    public function getIds(): array
    {
        return [$this->id];
    }

    /** @return class-string */
    public function getClassFullyQualifiedName(): string
    {
        return $this->className;
    }
}

;