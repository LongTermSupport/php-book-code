<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Entity;

use Book\Part1\Chapter3\ToyMvc\Model\Collection\PostCollection;

class CategoryEntity implements EntityInterface
{
    public function __construct(
        private Uuid $uuid,
        private string $name,
        private PostCollection $postCollection
    ) {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPostCollection(): PostCollection
    {
        return $this->postCollection;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }
}