<?php

declare(strict_types=1);

/**
 * A trait to allow public read but not public right for all properties in a class.
 * Suggest usage is combined with the `@property-read` annotation
 */
trait PublicRead
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

/**
 * @property-read $name
 */
class Person
{
    use PublicRead;

    public function __construct(
        protected string $name
    ) {
    }
}

/**
 * @property-read $id
 */
abstract class AbstractUser extends Person
{
    public function __construct(
        protected int $id,
        protected string $name
    ) {
        parent::__construct($name);
    }

    abstract public function __toString();
}

/**
 * @property-read $recentlyViewedPages
 */
final class FrontEndUser extends AbstractUser
{
    public function __construct(
        protected array $recentlyViewedPages,
        protected int $id,
        protected string $name
    ) {
        parent::__construct($id, $name);
    }

    public function __toString(): string
    {
        return "front end user $this->name ($this->id) has recently viewed: " .
               print_r($this->recentlyViewedPages, true);
    }
}

/**
 * @property-read $permName
 * @property-read $can
 */
final class AdminPermission
{
    use PublicRead;

    public function __construct(
        private string $permName,
        private bool $can,
    ) {
    }
}

/**
 * @property-read
 */
final class AdminUser extends AbstractUser
{
    /** @var array<string,AdminPermission> */
    private array $permissions;

    public function __construct(
        protected int $id,
        protected string $name,
        AdminPermission ...$permissions
    ) {
        parent::__construct($id, $name);
        array_map(
            function (AdminPermission $perm) {
                $this->permissions[$perm->permName] = $perm;
            },
            $permissions
        );
    }

    public function __toString(): string
    {
        return "admin user $this->name ($this->id) has these permissions: " .
               print_r($this->permissions, true);
    }

}