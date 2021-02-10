<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\View\Data;

use Book\Part1\Chapter3\ToyMvc\Model\Collection\CategoryCollection;

final class HomePageData
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