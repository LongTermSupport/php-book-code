<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2\CoContra;

abstract class ParentClass
{
    abstract public function getSomething(
        ParentInterface $thing
    ): ParentInterface;
}
