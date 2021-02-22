<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2;

function truthy(mixed $input): string
{
    $equal     = var_export($input == true, true);
    $identical = var_export($input === true, true);
    $if        = var_export(($input) ? true : false, true);

    $empty = var_export(empty($input), true);
    $isset = var_export(isset($input), true);
    switch (true) {
        case $input:
            $switch = 'true';
            break;
        default:
            $switch = 'false';
    }
    $match = match (true) {
        $input => 'true',
        default => 'false',
    };

    return "\nVar: " . var_export($input, true)
           . "\n Equal: {$equal} | Identical: {$identical} | If: {$if} | Empty: {$empty} "
           . "\n Isset: {$isset} | Switch: {$switch} | Match: {$match} \n";
}

foreach ([null, 0, 0.0, '0', '', false, true, 1, 'a', 01, -1, 0.1] as $value) {
    echo truthy($value);
}
