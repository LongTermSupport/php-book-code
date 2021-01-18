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

# Class CAN be instantiated and inherited from
/**
 * @property-read $name
 */
class Person
{
    /** Using the PublicRead trait to allow read only access to properties */
    use PublicRead;

    public function __construct(
        protected string $name
    ) {
    }
}

# Class CANNOT be instantiated, CAN be inherited from
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

    # Abstract function - must be defined in child classes
    abstract public function __toString();
}

# Class CAN be instantiated, CANNOT be inherited from
/**
 * @property-read $id
 * @property-read $name
 * @property-read $recentlyViewedPages
 */
final class FrontEndUser extends AbstractUser
{
    /** @var string[] */
    private array $recentlyViewedPages;

    public function __construct(
        protected int $id,
        protected string $name,
        string ...$recentlyViewedPages
    ) {
        parent::__construct($id, $name);
        $this->recentlyViewedPages = $recentlyViewedPages;
    }

    public function __toString(): string
    {
        return "front end user $this->name ($this->id) has recently viewed: " .
               print_r($this->recentlyViewedPages, true);
    }
}

# Class CAN be instantiated, CANNOT be inherited from
/**
 * @property-read $permName
 * @property-read $can
 */
final class AdminPermission
{
    public const CAN_EDIT = 'canEdit';
    public const CAN_VIEW = 'canView';
    public const PERMS    = [
        self::CAN_EDIT,
        self::CAN_VIEW,
    ];
    /** Using the PublicRead trait to allow read only access to properties */
    use PublicRead;

    public function __construct(
        private string $permName,
        private bool $can,
    ) {
        $this->assertValidName();
    }

    private function assertValidName(): void
    {
        if (in_array($this->permName, self::PERMS, true)) {
            return;
        }
        throw new \InvalidArgumentException(
            'Invalid permName ' . $this->permName .
            ', must be one of ' . print_r(self::PERMS, true)
        );
    }
}

# Class CAN be instantiated, CANNOT be inherited from
/**
 * @property-read $id
 * @property-read $name
 * @property-read $permissions
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
        return "\n\nadmin user $this->name ($this->id) has these permissions: \n" .
               implode("\n",
                       array_map(
                           static function (AdminPermission $perm) {
                               return $perm->permName . ': ' . ($perm->can ? 'true' : 'false');
                           },
                           $this->permissions
                       )
               ) . "\n";
    }
}

$frontEndUser = new FrontEndUser(
    2, 'Steve', 'http://php.com', 'http://something.com'
);
echo $frontEndUser;

$adminUser = new AdminUser(
    1,
    'Joseph',
    new AdminPermission(permName: AdminPermission::CAN_VIEW, can: true),
    new AdminPermission(permName: AdminPermission::CAN_EDIT, can: true)
);
echo $adminUser;