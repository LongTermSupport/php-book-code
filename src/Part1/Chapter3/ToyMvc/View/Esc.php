<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\View;

class Esc
{
    public static function _(string $input): string
    {
        return htmlspecialchars(string: $input, flags: ENT_QUOTES);
    }
}