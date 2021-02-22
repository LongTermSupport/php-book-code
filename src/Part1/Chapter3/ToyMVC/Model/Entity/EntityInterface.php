<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\Model\Entity;

interface EntityInterface
{
    public function getUuid(): Uuid;
}
