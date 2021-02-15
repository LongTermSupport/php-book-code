<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\Controller\HomePageController;
use PHPUnit\Framework\TestCase;

/**
 * @small
 * @covers \Book\Part1\Chapter3\ToyMvc\Controller\HomePageController
 *
 * @internal
 */
final class HomePageControllerTest extends TestCase
{
    /** @test */
    public function itLoadsTheHomePage(): void
    {
        $response = HomePageController::create([])
            ->getResponse(
                new RequestData(
                    '/',
                    new RequestMethod(RequestMethod::METHOD_GET)
                )
            )
        ;
        ob_start();
        $response->send();
        $actual = (string)ob_get_clean();
        self::assertStringContainsString('</html>', $actual);
    }
}
