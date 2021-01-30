<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2\TypeInheritance;

final class ChildClassOne
    extends ParentClass
    implements ParentInterfaceOne, ParentInterfaceTwo, RandomInterfaceThree
{

}