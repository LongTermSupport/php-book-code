<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Entity;

use InvalidArgumentException;
use Stringable;

/**
 * This is a very simple UUID generator, inspired by https://github.com/abmmhasan/UUID/blob/main/src/Uuid.php
 * This is not suggested for production code!
 */
final class Uuid implements Stringable
{
    public const DATA_KEY  = 'uuid';
    private const VERSION  = 4;

    public function __construct(private string $uuid)
    {
        if ($this->isValid($this->uuid) === false) {
            throw new InvalidArgumentException('Invalid UUID ' . $this->uuid);
        }
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public static function create(): self
    {
        $hex    = bin2hex(random_bytes(16));
        $chunks = str_split($hex, 4);

        $uuidString = sprintf(
            '%08s-%04s-' . self::VERSION . '%03s-%04x-%012s',
            $chunks[0] . $chunks[1],
            $chunks[2],
            substr($chunks[3], 1, 3),
            hexdec($chunks[4]) & 0x3fff | 0x8000,
            $chunks[5] . $chunks[6] . $chunks[7]
        );

        return new self($uuidString);
    }

    public function matches(self $uuid): bool
    {
        return (string)$this === (string)$uuid;
    }

    private function isValid(string $uuid): bool
    {
        return (bool)preg_match('{^[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12}$}Di', $uuid);
    }
}
