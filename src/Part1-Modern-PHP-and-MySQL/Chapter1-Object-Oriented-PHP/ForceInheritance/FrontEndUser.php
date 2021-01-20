<?php

declare(strict_types=1);

namespace Book\ForceInheritance;

/**
 * Class CAN be instantiated, CANNOT be inherited from
 *
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