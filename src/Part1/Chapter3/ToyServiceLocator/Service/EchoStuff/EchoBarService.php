<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyServiceLocator\Service\EchoStuff;

final class EchoBarService implements EchoStuffInterface
{
    public function echoSomething(): void
    {
        echo "\nbar";
    }
}
