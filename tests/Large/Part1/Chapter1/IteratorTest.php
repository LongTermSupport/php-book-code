<?php

declare(strict_types=1);

namespace Book\Tests\Large\Part1\Chapter1;

use Book\Tests\Assets\OutputGetter;
use PHPUnit\Framework\TestCase;

class IteratorTest extends TestCase
{
    private const SCRIPT_PATH     = __DIR__ . '/../../../../src/Part1/Chapter1/iterator.php';
    private const EXPECTED_OUTPUT = <<<TEXT
And so ends the whistle stop tour of iterators, I hope you had fun :)
TEXT;

    /** @test */
    public function outputIsAsExpected(): void
    {
        $actual = OutputGetter::getOutput(self::SCRIPT_PATH);
        self::assertStringContainsString(self::EXPECTED_OUTPUT, $actual);
    }
}