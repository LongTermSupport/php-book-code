<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Entity;

use Stringable;

/**
 * This is a very simple UUID generator, inspired by https://github.com/abmmhasan/UUID/blob/main/src/Uuid.php
 * This is not suggested for production code!
 */
final class Uuid implements Stringable
{
    private const VERSION  = 4;
    public const  DATA_KEY = 'uuid';

    public function __construct(private string $uuid)
    {

    }

    public static function create(): self
    {

        $hex    = bin2hex(random_bytes(16));
        $chunks = str_split($hex, 4);

        $uuidString = sprintf("%08s-%04s-" . self::VERSION . "%03s-%04x-%012s",
                              $chunks[0] . $chunks[1],
                              $chunks[2],
                              substr($chunks[3], 1, 3),
                              hexdec($chunks[4]) & 0x3fff | 0x8000,
                              $chunks[5] . $chunks[6] . $chunks[7]
        );

        return new self($uuidString);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}