<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI;

use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelOneDep;
use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelOneService;
use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelThreeDep;
use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelThreeService;
use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelTwoDep;
use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelTwoService;
use Book\Part1\Chapter3\ToyDI\Service\EchoStuff\EchoBarService;
use Book\Part1\Chapter3\ToyDI\Service\EchoStuff\EchoStuffInterface;
use Book\Part1\Chapter3\ToyDI\Service\MathsStuff\AdditionService;
use Book\Part1\Chapter3\ToyDI\Service\MathsStuff\MathsInterface;

final class AppContainerFactory
{
    private const SERVICES = [
        MathsInterface::class     => AdditionService::class,
        EchoStuffInterface::class => EchoBarService::class,
        LevelOneService::class    => LevelOneService::class,
        LevelOneDep::class        => LevelOneDep::class,
        LevelTwoService::class    => LevelTwoService::class,
        LevelTwoDep::class        => LevelTwoDep::class,
        LevelThreeService::class  => LevelThreeService::class,
        LevelThreeDep::class      => LevelThreeDep::class,
    ];

    public function buildAppContainer(): ServiceLocator
    {
        return new ServiceLocator(...$this->getSimpleDefinitions());
    }

    /** @return ServiceDefinitionInterface[] */
    private function getSimpleDefinitions(): array
    {
        $definitions = [];
        foreach (self::SERVICES as $id => $className) {
            $definitions[] = $this->getSimpleDefinition($id, $className);
        }

        return $definitions;
    }

    /**
     * @param class-string $id
     * @param class-string $className
     */
    private function getSimpleDefinition(string $id, string $className): SimpleServiceDefinition
    {
        return new SimpleServiceDefinition($id, $className);
    }
}
