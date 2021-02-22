<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\View\Data;

use Book\Part1\Chapter3\ToyMVC\Model\Entity\PostEntity;

final class PostPageData implements TemplateDataInterface
{
    public function __construct(
        private PostEntity $postEntity
    ) {
    }

    public function getPost(): PostEntity
    {
        return $this->postEntity;
    }
}
