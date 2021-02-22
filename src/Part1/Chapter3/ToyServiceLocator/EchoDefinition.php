<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyServiceLocator;

use Book\Part1\Chapter3\ToyServiceLocator\Service\EchoStuff\EchoBarService;
use Book\Part1\Chapter3\ToyServiceLocator\Service\EchoStuff\EchoStuffInterface;

final class EchoDefinition implements ServiceDefinitionInterface
{
    public function getInterfaceFullyQualifiedNames(): array
    {
        return [EchoStuffInterface::class];
    }

    public function getClassFullyQualifiedName(): string
    {
        return EchoBarService::class;
    }
}
