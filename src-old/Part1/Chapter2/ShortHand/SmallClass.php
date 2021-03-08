<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2\ShortHand;

final class SmallClass
{
    public function __construct(
        public ?string $foo
    ) {
    }
}
