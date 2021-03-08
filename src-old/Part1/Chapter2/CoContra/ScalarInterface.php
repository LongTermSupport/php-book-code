<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2\CoContra;

interface ScalarInterface
{
    public function doSomething(string | int $foo): string;
}
