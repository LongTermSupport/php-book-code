<?php

declare(strict_types=1);
/**
 * A trait to allow public read but not public right for all properties in a class.
 * Suggest usage is combined with the `@property-read` annotation
 */

namespace Book\ForceInheritance;

trait PublicReadTrait
{
    final public function __get(string $name): mixed
    {
        $this->assertPropertyExists($name);

        return $this->$name;
    }

    private function assertPropertyExists(string $name): void
    {
        if ($this->__isset($name)) {
            return;
        }
        throw new \InvalidArgumentException(
            'Property ' . $name . ' does not exist or is not accessible in ' . static::class
        );
    }

    final public function __set(string $name, mixed $value): void
    {
        $this->assertPropertyExists($name);
        throw new \RuntimeException('Property ' . $name . ' is read only');
    }

    final public function __isset(
        $name
    ): bool {
        return property_exists($this, $name);
    }
}