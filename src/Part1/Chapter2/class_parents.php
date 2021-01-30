<?php

declare(strict_types=1);

require __DIR__ . '/../../../vendor/autoload.php';

use Book\Part1\Chapter2\TypeInheritance\ChildClassOne;
use Book\Part1\Chapter2\TypeInheritance\RandomInterfaceFour;

$child                = new ChildClassOne();
$childClassParents    = array_values(class_parents($child));
$childClassInterfaces = array_values(class_implements($child));

echo "\nClass Parents of ChildClassOne:\n" . var_export($childClassParents, true);

echo "\nInterfaces of ChildClassOne:\n" . var_export($childClassInterfaces, true);

function isInstanceOf(object $object, string $item): string
{
    $format = "\nClass is an instance of %-60s %s\n";
    $result = var_export($object instanceof $item, true);

    return sprintf($format, "$item?", $result);
}

foreach ($childClassParents + $childClassInterfaces as $item) {
    echo isInstanceOf($child, $item);
}

$otherTypes = [RandomInterfaceFour::class, stdClass::class];
foreach ($otherTypes as $item) {
    echo isInstanceOf($child, $item);
}