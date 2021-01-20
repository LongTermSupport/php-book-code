<?php

declare(strict_types=1);

namespace Book\ForceInheritance;

/**
 * Class CAN be instantiated, CANNOT be inherited from
 *
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
    use PublicReadTrait;

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