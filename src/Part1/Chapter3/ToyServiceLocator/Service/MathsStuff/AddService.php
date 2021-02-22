<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyServiceLocator\Service\MathsStuff;

final class AddService implements MathsInterface
{
    public function getResult(float | int $numberOne, float | int $numberTwo): int | float
    {
        return $numberOne + $numberTwo;
    }
}
