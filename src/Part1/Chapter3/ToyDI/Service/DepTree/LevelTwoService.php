<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI\Service\DepTree;

final class LevelTwoService
{
    public function __construct(
        public LevelTwoDep $levelTwoDep,
        public LevelThreeService $levelThreeService,
        public UbiquitousService $ubiquitousService
    ) {
    }
}
