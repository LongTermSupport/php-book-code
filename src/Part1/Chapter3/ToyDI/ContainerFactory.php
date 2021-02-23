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

final class ContainerFactory
{
    public const SHORTHAND_NAME_FOR_MATHS  = 'maths';
    private const SERVICE_CLASSES_TO_IDS   = [
        AdditionService::class   => [
            MathsInterface::class,
            AdditionService::class,
            self::SHORTHAND_NAME_FOR_MATHS,
        ],
        EchoBarService::class    => [
            EchoStuffInterface::class,
            EchoBarService::class,
        ],
        LevelOneService::class   => [LevelOneService::class],
        LevelOneDep::class       => [LevelOneDep::class],
        LevelTwoService::class   => [LevelTwoService::class],
        LevelTwoDep::class       => [LevelTwoDep::class],
        LevelThreeService::class => [LevelThreeService::class],
        LevelThreeDep::class     => [LevelThreeDep::class],
    ];

    public function buildAppContainer(): ServiceLocator
    {
        return new ServiceLocator(...$this->getSimpleDefinitions());
    }

    /** @return ServiceDefinitionInterface[] */
    private function getSimpleDefinitions(): array
    {
        $definitions = [];
        foreach (self::SERVICE_CLASSES_TO_IDS as $className => $ids) {
            $definitions[] = $this->getSimpleDefinition($ids, $className);
        }

        return $definitions;
    }

    /**
     * @param array<int,string> $ids
     * @param class-string      $className
     */
    private function getSimpleDefinition(array $ids, string $className): SimpleServiceDefinition
    {
        return new SimpleServiceDefinition($ids, $className);
    }
}
