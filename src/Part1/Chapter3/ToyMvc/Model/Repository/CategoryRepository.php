<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Repository;

use Book\Part1\Chapter3\ToyMvc\Model\Collection\CategoryCollection;
use Book\Part1\Chapter3\ToyMvc\Model\Database;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\CategoryEntity;

class CategoryRepository
{
    public function __construct(private Database $database)
    {
    }

    public function loadAll(): CategoryCollection
    {
        $entities = [];
        $data     = $this->database->loadAll(Database::TABLE_CATEGORY);
        foreach ($data as $datum) {
            $entities = new CategoryEntity(...$datum);
        }

        return new CategoryCollection(...$entities);
    }
}