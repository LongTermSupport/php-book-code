<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Collection;

use Book\Part1\Chapter3\ToyMvc\Model\Entity\PostEntity;

class PostCollection
{
    /** @var PostEntity[] */
    private array $postEntities;

    public function __construct(PostEntity...$postEntities)
    {
        $this->postEntities = $postEntities;
    }

    /** @return PostEntity[] */
    public function getPostEntities(): array
    {
        return $this->postEntities;
    }
}