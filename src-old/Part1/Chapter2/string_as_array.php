<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2;

$string = <<<'TEXT'
    this is a string
    TEXT;

echo "\n\n{$string[0]}\n\n";
