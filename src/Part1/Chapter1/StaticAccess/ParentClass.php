<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\StaticAccess;

final class ParentClass
{
    private const ZIP          = '123';
    private static string $foo = 'bar';

    public static function getStringSelf(): string
    {
        return self::$foo . self::ZIP;
    }

    public static function getStringStatic(): string
    {
        return static::$foo . static::ZIP;
    }
}