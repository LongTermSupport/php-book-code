<?php

declare(strict_types=1);

final class Person
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

final class UserData
{
    public function __construct(
        private int $id,
        private Person $person
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->person->getName();
    }
}

final class UrlCollection
{
    /**
     * @var string[]
     */
    private array $urls;

    public function __construct(string ...$urls)
    {
        $this->urls = $urls;
    }

    /**
     * @return string[]
     */
    public function getUrls(): array
    {
        return $this->urls;
    }
}

interface User
{
    public function __toString();
}

final class FrontEndUser implements User
{
    public function __construct(
        private UserData $userData,
        private UrlCollection $recentlyViewedPages
    ) {
    }

    public function __toString(): string
    {
        return "front end user {$this->userData->getName()} ({$this->userData->getId()}) has recently viewed: " .
               print_r($this->recentlyViewedPages->getUrls(), true);
    }
}

interface AdminPermissionInterface
{
    public const CAN_EDIT = 'canEdit';
    public const CAN_VIEW = 'canView';
    public const PERMS    = [
        self::CAN_EDIT,
        self::CAN_VIEW,
    ];

    public function getPermName(): string;

    public function allowed(): bool;
}

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

final class CanViewPermission implements AdminPermissionInterface
{
    public function __construct(
        private bool $allowed
    ) {
    }

    public function getPermName(): string
    {
        return self::CAN_VIEW;
    }

    public function allowed(): bool
    {
        return $this->allowed;
    }
}

final class AdminUser implements User
{
    /** @var array<string,AdminPermission> */
    private array $permissions;

    public function __construct(
        private UserData $userData,
        AdminPermissionInterface ...$permissions
    ) {
        array_map(
            function (AdminPermissionInterface $perm) {
                $this->permissions[$perm->getPermName()] = $perm;
            },
            $permissions
        );
    }

    public function __toString(): string
    {
        return "\n\nadmin user {$this->userData->getName()} ({$this->userData->getId()}) has these permissions: \n" .
               implode("\n",
                       array_map(
                           static function (AdminPermissionInterface $perm) {
                               return $perm->getPermName() . ': ' . ($perm->allowed() ? 'true' : 'false');
                           },
                           $this->permissions
                       )
               ) . "\n";
    }
}

$frontEndUser = new FrontEndUser(
    new UserData(id: 2, person: new Person(name: 'Steve')),
    new UrlCollection('http://php.com', 'http://something.com')
);
echo $frontEndUser;

$adminUser = new AdminUser(
    new UserData(id: 1, person: new Person(name: 'Joseph')),
    new CanEditPermission(allowed: true),
    new CanViewPermission(allowed: true)
);
echo $adminUser;