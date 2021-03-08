<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\View\Data;

use Book\Part1\Chapter3\ToyMVC\Model\Entity\CategoryEntity;

final class CategoryPageData implements TemplateDataInterface
{
    public function __construct(
        private CategoryEntity $category
    ) {
    }

    public function getCategory(): CategoryEntity
    {
        return $this->category;
    }
}
