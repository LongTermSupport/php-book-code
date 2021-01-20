<?php

declare(strict_types=1);

namespace Book\ForceInheritance;

/**
 * Class CAN be instantiated and inherited from
 *
 * @property-read $name
 */
class Person
{
    /** Using the PublicRead trait to allow read only access to properties */
    use PublicReadTrait;

    public function __construct(
        protected string $name
    ) {
    }
}