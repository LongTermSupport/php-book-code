<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\Model\Repository;

use Book\Part1\Chapter3\ToyMVC\FakeDataForToy;
use Book\Part1\Chapter3\ToyMVC\Model\Collection\CategoryCollection;
use Book\Part1\Chapter3\ToyMVC\Model\Entity\CategoryEntity;
use Book\Part1\Chapter3\ToyMVC\Model\Entity\Uuid;
use RuntimeException;

final class CategoryRepository
{
    public function loadAll(): CategoryCollection
    {
        // Imagine that this method uses an ORM layer to build entities from the DB
        return new CategoryCollection(...FakeDataForToy::singleton()->getCategoryEntities());
    }

    public function load(Uuid $uuid): CategoryEntity
    {
        // Imagine that this method uses an ORM layer to query for a specific Entity by ID
        foreach (FakeDataForToy::singleton()->getCategoryEntities() as $categoryEntity) {
            if ($categoryEntity->getUuid()->matches($uuid)) {
                return $categoryEntity;
            }
        }

        throw new RuntimeException('Failed finding category with ID ' .
                                   $uuid);
    }
}
