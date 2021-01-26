<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1;

// array_filter ( array $array , callable|null $callback = null , int $mode = 0 ) : array
$filtered = array_filter(
    array: [true, false, true],
    callback: static function ($item): bool {
        return $item === true;
    }
);

// array_map ( callable|null $callback , array $array , array ...$arrays ) : array
$mapped = array_map(
    array: [true, false, true],
    callback: static function ($item): bool {
        return !$item;
    }
);
