<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Collection;

use Book\Part1\Chapter3\ToyMvc\Model\Entity\CategoryEntity;

class CategoryCollection
{
    /** @var CategoryEntity[] */
    private array $categoryEntities;

    public function __construct(CategoryEntity...$categoryEntities)
    {
        $this->categoryEntities = $categoryEntities;
    }

    /** @return CategoryEntity[] */
    public function getCategoryEntities(): array
    {
        return $this->categoryEntities;
    }
}