<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\ForceInheritance;

use function PHPUnit\Framework\callback;

/**
 * Class CAN be instantiated, CANNOT be inherited from
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
            callback: function (AdminPermission $perm): void {
            $this->permissions[$perm->getPermName()] = $perm;
        },
            array: $permissions
        );
    }

    public function __toString(): string
    {
        return "\n\nadmin user $this->name ($this->id) has these permissions: \n" .
               implode("\n",
                       array_map(
                           callback: static function (AdminPermission $perm): string {
                           return $perm->getPermName() . ': ' . ($perm->isAllowed() ? 'true' : 'false');
                       },
                           array: $this->permissions
                       )
               ) . "\n";
    }
}