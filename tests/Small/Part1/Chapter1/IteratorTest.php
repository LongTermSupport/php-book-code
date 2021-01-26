<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter1;

use Book\Tests\Assets\OutputGetter;
use PHPUnit\Framework\TestCase;

/**
 * @small
 *
 * @internal
 * @coversNothing
 */
final class IteratorTest extends TestCase
{
    private const SCRIPT_PATH     = __DIR__ . '/../../../../src/Part1/Chapter1/iterator.php';
    private const EXPECTED_OUTPUT = <<<'TEXT'
6 directories, 6 files
TEXT;

    /** @test */
    public function outputIsAsExpected(): void
    {
        $actual = OutputGetter::getOutput(self::SCRIPT_PATH);
        self::assertStringContainsString(self::EXPECTED_OUTPUT, $actual);
    }
}
