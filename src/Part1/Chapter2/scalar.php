<?php

declare(strict_types=1);

$isItScalar = [
    true,
    false,
    1,
    0,
    1.0,
    -1,
    'string',
    '',
    null,
    fopen(__FILE__, 'r'),
    function () {},
    new stdClass(),
];

foreach ($isItScalar as $item) {
    $var    = var_export($item, true);
    $type   = gettype($item);
    $scalar = (int)is_scalar($item);
    $string = (int)is_string($item);
    $int    = (int)is_int($item);
    $bool   = (int)is_bool($item);
    $float  = (int)is_float($item);
    echo "\nVar: $var\nType: $type Scalar: $scalar String: $string Int: $int Bool: $bool Float: $float\n";
}