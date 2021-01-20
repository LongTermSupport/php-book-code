<?php

declare(strict_types=1);

namespace Book\ForceInheritance;

/**
 * Class CAN be instantiated, CANNOT be inherited from
 *
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