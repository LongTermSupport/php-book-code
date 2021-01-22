<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\Composition\AdminPermission;

final class CanEditPermission implements AdminPermissionInterface
{
    public function __construct(
        private bool $allowed
    ) {
    }

    public function getPermName(): string
    {
        return self::CAN_EDIT;
    }

    public function allowed(): bool
    {
        return $this->allowed;
    }
}
