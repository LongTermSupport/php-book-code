<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller\Data;

use InvalidArgumentException;

final class RequestMethod
{
    public const METHOD_GET  = 'GET';
    public const METHOD_POST = 'POST';
    public const METHODS     = [
        self::METHOD_GET  => self::METHOD_GET,
        self::METHOD_POST => self::METHOD_POST,
    ];

    public function __construct(private string $name)
    {
        self::assertIsValidName($name);
        $this->name = strtoupper($this->name);
    }

    public static function assertIsValidName(string $name): void
    {
        if (isset(self::METHODS[$name])) {
            return;
        }
        throw new InvalidArgumentException(
            'Invalid method ' . $name . ', must be one of: ' . print_r(
                self::METHODS,
                true
            )
        );
    }

    public function getName(): string
    {
        return $this->name;
    }
}
