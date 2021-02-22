<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2\TypeInheritance;

final class ChildClass
    // can only inherit from a single parent class
    extends ParentClass
    // but can implement multiple interfaces, each of which can have their own inheritance chain
    implements ParentInterfaceOne, ParentInterfaceTwo, RandomInterfaceThree
{
}
