<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1;

use Book\Part1\Chapter1\Attributes\Bar;
use Book\Part1\Chapter1\Attributes\Baz;
use Book\Part1\Chapter1\Attributes\Foo;
use Book\Part1\Chapter1\Attributes\WrittenByAttribute;
use ReflectionClass;

/*
 * Now we can loop over the classes and dynamically pull out the attribute, get an instance and call methods on it
 */
foreach ([Foo::class, Bar::class, Baz::class] as $class) {
    $attributes = (new ReflectionClass($class))->getAttributes(WrittenByAttribute::class);

    /** @var WrittenByAttribute $writtenBy */
    $writtenBy = $attributes[0]->newInstance();

    echo "\nClass " . $class . ' was written by ' . $writtenBy->getName();
}
