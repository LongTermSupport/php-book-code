<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyDI;

use Book\Part1\Chapter3\ToyDI\ContainerFactory;
use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelOneService;
use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelThreeDep;
use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelThreeService;
use Book\Part1\Chapter3\ToyDI\Service\DepTree\LevelTwoService;
use Book\Part1\Chapter3\ToyDI\Service\EchoStuff\EchoBarService;
use Book\Part1\Chapter3\ToyDI\Service\EchoStuff\EchoFooService;
use Book\Part1\Chapter3\ToyDI\Service\EchoStuff\EchoStuffInterface;
use Book\Part1\Chapter3\ToyDI\Service\MathsStuff\AdditionService;
use Book\Part1\Chapter3\ToyDI\Service\MathsStuff\MathsInterface;
use Book\Part1\Chapter3\ToyDI\Service\MathsStuff\MultiplicationService;
use Book\Part1\Chapter3\ToyDI\ServiceLocator;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @small
 *
 * @internal
 * @covers \Book\Part1\Chapter3\ToyDI\ContainerFactory
 * @covers \Book\Part1\Chapter3\ToyDI\ServiceFactory
 * @covers \Book\Part1\Chapter3\ToyDI\ServiceLocator
 */
final class ContainerTest extends TestCase
{
    private ServiceLocator $container;

    public function setUp(): void
    {
        $this->container = (new ContainerFactory())->buildAppContainer();
    }

    /** @test */
    public function itCanGetEchoService(): void
    {
        self::assertInstanceOf(
            expected: EchoBarService::class,
            actual: $this->container->get(EchoStuffInterface::class)
        );
        self::assertInstanceOf(
            expected: EchoBarService::class,
            actual: $this->container->get(EchoBarService::class)
        );
    }

    /**
     * @test
     *
     * @return MathsInterface[]
     */
    public function itCanGetMathsService(): array
    {
        $byInterfaceId = $this->container->get(MathsInterface::class);
        self::assertInstanceOf(
            expected: AdditionService::class,
            actual: $byInterfaceId
        );
        $byClassId = $this->container->get(AdditionService::class);
        self::assertInstanceOf(
            expected: AdditionService::class,
            actual: $byClassId
        );
        $byShortName = $this->container->get(ContainerFactory::SHORTHAND_NAME_FOR_MATHS);
        self::assertInstanceOf(
            expected: AdditionService::class,
            actual: $byShortName
        );

        return [$byInterfaceId, $byClassId, $byShortName];
    }

    /**
     * @test
     * @depends itCanGetMathsService
     *
     * @param MathsInterface[] $services
     */
    public function itReturnsTheSameInstanceForAllIds(
        array $services
    ): void {
        [$byInterfaceId, $byClassId, $byShortName] = $services;
        $actual                                    = ($byInterfaceId === $byClassId) && ($byInterfaceId === $byShortName);
        self::assertTrue($actual);
    }

    /** @test */
    public function itCanBuildServicesWithDependencies(): void
    {
        /** @var LevelOneService $levelOneService */
        $levelOneService = $this->container->get(LevelOneService::class);
        self::assertInstanceOf(
            expected: LevelOneService::class,
            actual: $levelOneService
        );
        $levelThreeDep = $levelOneService->levelTwoService->levelThreeService->levelThreeDep;
        self::assertInstanceOf(
            expected: LevelThreeDep::class,
            actual: $levelThreeDep
        );
    }

    /**
     * @dataProvider
     *
     * @return Generator<string, array<int,string>>
     */
    public function provideValidServiceIds(): Generator
    {
        yield EchoStuffInterface::class => [EchoStuffInterface::class];
        yield MathsInterface::class => [MathsInterface::class];
        yield LevelOneService::class => [LevelOneService::class];
        yield LevelTwoService::class => [LevelTwoService::class];
        yield LevelThreeService::class => [LevelThreeService::class];
    }

    /**
     * @dataProvider provideValidServiceIds
     * @test
     */
    public function hasReturnsTrueForValidServiceIds(
        string $service
    ): void {
        self::assertTrue($this->container->has($service));
    }

    /**
     * @dataProvider
     *
     * @return Generator<string, array<int,string>>
     */
    public function provideInvalidServiceIds(): Generator
    {
        yield EchoFooService::class => [EchoFooService::class];
        yield MultiplicationService::class => [MultiplicationService::class];
        yield static::class => [static::class];
    }

    /**
     * @dataProvider provideInvalidServiceIds
     * @test
     */
    public function hasReturnsFalseForInvalidServiceIds(
        string $service
    ): void {
        self::assertFalse($this->container->has($service));
    }
}
