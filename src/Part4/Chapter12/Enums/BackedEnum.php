<?php

declare(strict_types=1);

namespace Book\Part4\Chapter12\Enums;

enum BackedEnum: string
{
    case Baz = 'Baz';
    case Taz = 'Taz';

    /** Enums can also define constants and methods, like a class */
    public const DEFAULT = self::Taz;

    /** Enums can use traits */
    use RandomCaseTrait;

    /** And define methods */
    public function getRandomCaseAsArray(): array
    {
        $caseName = $this->getRandomCaseName();
        $case     = self::from($caseName);

        return [$case->name, $case->value];
    }
}