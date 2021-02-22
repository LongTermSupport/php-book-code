<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI;

interface ServiceDefinitionInterface
{
    /** @return array<int, class-string> */
    public function getIds(): array;

    /** @return class-string */
    public function getClassFullyQualifiedName(): string;
}
