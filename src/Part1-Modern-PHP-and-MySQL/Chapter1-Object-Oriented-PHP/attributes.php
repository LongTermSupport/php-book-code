<?php

declare(strict_types=1);

/**
 * This class is the attribute itself. It has the magical `#[Attribute]` attribute which marks it as such
 */
#[Attribute]
class WrittenBy
{
    public function __construct(
        private string $name
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}

/**
 * Now we have three classes that implement this attribute:
 */
#[WrittenBy('Joseph')]
class Foo
{

}

#[WrittenBy('Jane')]
class Bar
{

}

#[WrittenBy('Steve')]
class Baz
{

}

/**
 * Now we can loop over the classes and dynamically pull out the attribute, get an instance and call methods on it
 */
foreach ([Foo::class, Bar::class, Baz::class] as $class) {
    echo "\nClass " . $class . " was written by " .
         (new ReflectionClass($class))->getAttributes(WrittenBy::class)[0]->newInstance()->getName();
}
