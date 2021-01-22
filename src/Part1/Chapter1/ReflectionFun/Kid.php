<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\ReflectionFun;

class Kid
{
    public function __construct(
        private string $name,
        private int $age
    ) {
    }

    private function nameChange(string $newName): void
    {
        $this->name = $newName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}