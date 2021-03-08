<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\Model\Repository;

use Book\Part1\Chapter3\ToyMVC\FakeDataForToy;
use Book\Part1\Chapter3\ToyMVC\Model\Collection\PostCollection;
use Book\Part1\Chapter3\ToyMVC\Model\Entity\PostEntity;
use Book\Part1\Chapter3\ToyMVC\Model\Entity\Uuid;
use RuntimeException;

final class PostRepository
{
    public function loadAll(): PostCollection
    {
        /* Imagine that this method uses an ORM layer to build entities from the DB */
        return new PostCollection(...FakeDataForToy::singleton()->getPostEntities());
    }

    public function load(Uuid $uuid): PostEntity
    {
        $data = FakeDataForToy::singleton()->getPostEntities();

        return $data[(string)$uuid]
               ??
               throw new RuntimeException('Failed finding Post with ID ' .
                                          $uuid);
    }
}
