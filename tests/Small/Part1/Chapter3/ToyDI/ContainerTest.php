<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyDI;

use Book\Part1\Chapter3\ToyDI\AppContainerFactory;
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
 * @coversNothing
 */
final class ContainerTest extends TestCase
{
    private ServiceLocator $container;

    public function setUp(): void
    {
        $this->container = (new AppContainerFactory())->buildAppContainer();
    }

    /** @test */
    public function itCanGetEchoService(): void
    {
        self::assertInstanceOf(EchoBarService::class, $this->container->get(EchoStuffInterface::class));
    }

    /** @test */
    public function itCanGetMathsService(): void
    {
        self::assertInstanceOf(AdditionService::class, $this->container->get(MathsInterface::class));
    }

    /** @test */
    public function itCanBuildServicesWithDependencies(): void
    {
        /** @var LevelOneService $level */
        $level = $this->container->get(LevelOneService::class);
        self::assertInstanceOf(LevelOneService::class, $level);
        $levelThreeDep = $level->levelTwoService->levelThreeService->levelThreeDep;
        self::assertInstanceOf(LevelThreeDep::class, $levelThreeDep);
    }

    /**
     * @dataProvider
     *
     * @return Generator<string, array<int,string>>
     */
    public function provideHasStuff(): Generator
    {
        yield EchoStuffInterface::class => [EchoStuffInterface::class];
        yield MathsInterface::class => [MathsInterface::class];
        yield LevelOneService::class => [LevelOneService::class];
        yield LevelTwoService::class => [LevelTwoService::class];
        yield LevelThreeService::class => [LevelThreeService::class];
    }

    /**
     * @dataProvider provideHasStuff
     * @test
     */
    public function itCanHasStuff(
        string $service
    ): void {
        self::assertTrue($this->container->has($service));
    }

    /**
     * @dataProvider
     *
     * @return Generator<string, array<int,string>>
     */
    public function provideNotHasStuff(): Generator
    {
        yield EchoFooService::class => [EchoFooService::class];
        yield MultiplicationService::class => [MultiplicationService::class];
        yield static::class => [static::class];
    }

    /**
     * @dataProvider provideNotHasStuff
     * @test
     */
    public function itCanNotHasStuff(
        string $service
    ): void {
        self::assertFalse($this->container->has($service));
    }
}
