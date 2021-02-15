<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyMvc\Model;

use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    private const TEST_ITERATION_CNT = 100;

    /**
     * @test
     */
    public function itGeneratesAndValidatesUuids(): void
    {
        for ($x = 0; $x <= self::TEST_ITERATION_CNT; $x++) {
            $uuid = Uuid::create();
            self::assertNotEmpty((string)$uuid);
        }
    }
}