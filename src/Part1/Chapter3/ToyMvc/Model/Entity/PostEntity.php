<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Entity;

final class PostEntity
{
    public function __construct(
        private string $title,
        private string $contentHtml
    ) {

    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentHtml(): string
    {
        return $this->contentHtml;
    }


}