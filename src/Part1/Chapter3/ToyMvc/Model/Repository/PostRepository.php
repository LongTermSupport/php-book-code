<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Repository;

use Book\Part1\Chapter3\ToyMvc\FakeDataForToy;
use Book\Part1\Chapter3\ToyMvc\Model\Collection\PostCollection;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\PostEntity;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;
use RuntimeException;

final class PostRepository
{
    /** @var PostEntity[]* */
    private array $data;

    public function __construct()
    {
        $this->data = FakeDataForToy::singleton()->getPostEntities();
    }

    public function loadAll(): PostCollection
    {
        /* Imagine that this method uses an ORM layer to build entities from the DB */
        return new PostCollection(...$this->data);
    }

    public function load(Uuid $uuid): PostEntity
    {
        return $this->data[(string)$uuid] ?? throw new RuntimeException('Failed finding category with ID ' . $uuid);
    }
}
