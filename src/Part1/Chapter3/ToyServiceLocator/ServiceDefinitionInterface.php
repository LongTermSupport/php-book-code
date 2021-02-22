<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyServiceLocator;

interface ServiceDefinitionInterface
{
    /** @return array<int, class-string> */
    public function getInterfaceFullyQualifiedNames(): array;

    /** @return class-string */
    public function getClassFullyQualifiedName(): string;
}
