<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyMvc\Model\Repository;

use Book\Part1\Chapter3\ToyMvc\Model\Entity\CategoryEntity;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\CategoryRepository;
use PHPUnit\Framework\TestCase;

/**
 * @small
 *
 * @internal
 * @covers \Book\Part1\Chapter3\ToyMvc\Model\Repository\CategoryRepository
 */
final class CategoryRepositoryTest extends TestCase
{
    private CategoryRepository $repo;

    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new CategoryRepository();
    }

    /** @test */
    public function itCanLoadAllCategories(): void
    {
        $actual = $this->repo->loadAll();
        self::assertGreaterThan(0, $actual->count());
        foreach ($actual as $item) {
            self::assertInstanceOf(CategoryEntity::class, $item);
        }
    }
}
