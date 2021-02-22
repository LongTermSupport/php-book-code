<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\Inheritance;

final class MyClass
    // Single Inheritance of Classes
    extends MyParentClass
    // Multiple Implementation of Interfaces
    implements GetsBarInterface, GetsFooInterface
{
    public function getFoo(): int
    {
        return $this->foo;
    }

    public function getBar(): int
    {
        return $this->bar;
    }
}
