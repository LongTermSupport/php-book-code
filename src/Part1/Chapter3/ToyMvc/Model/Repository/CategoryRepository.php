<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Repository;

use Book\Part1\Chapter3\ToyMvc\FakeDataForToy;
use Book\Part1\Chapter3\ToyMvc\Model\Collection\CategoryCollection;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\CategoryEntity;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;
use RuntimeException;

final class CategoryRepository
{
    /**
     * This is just for the toy,
     * you would never normally store all your data in your repository!
     *
     * @var CategoryEntity[]*
     */
    private array $data;

    public function __construct()
    {
        // just for the toy
        $this->data = FakeDataForToy::singleton()->getCategoryEntities();
    }

    public function loadAll(): CategoryCollection
    {
        // Imagine that this method uses an ORM layer to build entities from the DB
        return new CategoryCollection(...$this->data);
    }

    public function load(Uuid $uuid): CategoryEntity
    {
        // Imagine that this method uses an ORM layer to query for a specific Entity by ID
        foreach ($this->data as $categoryEntity) {
            if ($categoryEntity->getUuid()->matches($uuid)) {
                return $categoryEntity;
            }
        }

        throw new RuntimeException('Failed finding category with ID ' . $uuid);
    }
}
