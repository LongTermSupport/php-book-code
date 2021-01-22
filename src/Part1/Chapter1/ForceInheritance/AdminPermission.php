<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\ForceInheritance;

use InvalidArgumentException;

/**
 * Class CAN be instantiated, CANNOT be inherited from.
 */
final class AdminPermission
{
    public const CAN_EDIT = 'canEdit';
    public const CAN_VIEW = 'canView';
    public const PERMS    = [
        self::CAN_EDIT,
        self::CAN_VIEW,
    ];

    public function __construct(
        private string $permName,
        private bool $allowed,
    ) {
        $this->assertValidName();
    }

    public function getPermName(): string
    {
        return $this->permName;
    }

    public function isAllowed(): bool
    {
        return $this->allowed;
    }

    private function assertValidName(): void
    {
        if (in_array($this->permName, self::PERMS, true)) {
            return;
        }
        throw new InvalidArgumentException(
            'Invalid permName ' . $this->permName .
            ', must be one of ' . print_r(self::PERMS, true)
        );
    }
}
