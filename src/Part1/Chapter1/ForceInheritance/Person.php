<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\ForceInheritance;

/**
 * Class CAN be instantiated and inherited from.
 */
class Person
{
    public function __construct(
    protected string $name
    ) {
    }
}
