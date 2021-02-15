<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Collection;

use Book\Part1\Chapter3\ToyMvc\Model\Entity\CategoryEntity;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;

final class CategoryCollection implements \Iterator, \Countable
{
    /** @var CategoryEntity[] * */
    private array $categoryEntities;

    public function __construct(CategoryEntity...$categoryEntities)
    {
        $this->categoryEntities = $categoryEntities;
    }

    public function current(): CategoryEntity
    {
        return current($this->categoryEntities);
    }

    public function next(): bool|CategoryEntity
    {
        return next($this->categoryEntities);
    }

    public function key(): Uuid
    {
        return $this->current()->getUuid();
    }

    public function valid(): bool
    {
        return key($this->categoryEntities) !== null;
    }

    public function rewind(): void
    {
        reset($this->categoryEntities);
    }

    public function count(): int
    {
        return count($this->categoryEntities);
    }
}