<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI\Service\EchoStuff;

final class EchoBarService implements EchoStuffInterface
{
    public function __construct()
    {
    }

    public function echoSomething(): void
    {
        echo "\nbar";
    }
}
