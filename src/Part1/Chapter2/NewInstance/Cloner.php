<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2\NewInstance;

final class Cloner
{
    public string $state = 'limbo';

    public function __construct()
    {
        $this->state = 'constructed';
    }

    public function __clone()
    {
        $this->state = 'cloned';
        echo "\nI am multiplying: hey me, meet me";
    }

    /** The actual ID for the unique object isntance */
    public function getObjectId(): int
    {
        return spl_object_id($this);
    }
}
