<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI\Service\DepTree;

final class LevelOneService
{
    public function __construct(public LevelOneDep $levelOneDep, public LevelTwoService $levelTwoService)
    {
    }
}
