<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyServiceLocator\Service\MathsStuff;

interface MathsInterface
{
    public function getResult(int | float $numberOne, int | float $numberTwo): int | float;
}
