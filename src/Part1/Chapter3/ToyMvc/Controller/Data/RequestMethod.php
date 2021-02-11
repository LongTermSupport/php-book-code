<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller\Data;

class RequestMethod
{
    public const METHOD_GET  = 'get';
    public const METHOD_POST = 'post';
    public const METHODS     = [
        self::METHOD_GET,
        self::METHOD_POST,
    ];

    public function __construct(private string $name)
    {
        if (false === in_array(needle: $this->name, haystack: self::METHODS, strict: true)) {
            throw new \InvalidArgumentException(
                'Invalid method ' . $this->name . ', must be one of: ' . print_r(self::METHODS,
                                                                                 true
                )
            );
        }
    }

    public function getName(): string
    {
        return $this->name;
    }
}