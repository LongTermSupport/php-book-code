<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2\ShortHand;

final class Container
{
    public bool $bool1 = true;

    public function __construct(
        public ?SmallClass $property1,
        public ?SmallClass $property2
    ) {
    }
}
