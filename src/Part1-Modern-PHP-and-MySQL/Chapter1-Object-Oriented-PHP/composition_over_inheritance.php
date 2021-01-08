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

$frontEndUser = new FrontEndUser(
    new UserData(id: 2, person: new Person(name: 'Steve')),
    new UrlCollection('http://php.com', 'http://something.com')
);
echo $frontEndUser;
