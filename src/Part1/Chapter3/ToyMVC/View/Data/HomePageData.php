<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\View\Data;

use Book\Part1\Chapter3\ToyMVC\Model\Collection\CategoryCollection;

final class HomePageData implements TemplateDataInterface
{
    public function __construct(
        private CategoryCollection $categoryCollection
    ) {
    }

    public function getCategoryCollection(): CategoryCollection
    {
        return $this->categoryCollection;
    }
}
