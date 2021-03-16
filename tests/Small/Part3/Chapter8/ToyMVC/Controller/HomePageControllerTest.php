<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part3\Chapter8\ToyMVC\Controller;

use Book\Part3\Chapter8\ToyMVC\Controller\Data\RequestData;
use Book\Part3\Chapter8\ToyMVC\Controller\Data\RequestMethod;
use Book\Part3\Chapter8\ToyMVC\Controller\HomePageController;
use Book\Part3\Chapter8\ToyMVC\Model\Repository\CategoryRepository;
use Book\Part3\Chapter8\ToyMVC\View\TemplateRenderer;
use PHPUnit\Framework\TestCase;

/**
 * @small
 * @covers \Book\Part3\Chapter8\ToyMVC\Controller\HomePageController
 *
 * @internal
 */
final class HomePageControllerTest extends TestCase
{
    private HomePageController $controller;

    public function setUp(): void
    {
        $this->controller = new HomePageController(new CategoryRepository(), new TemplateRenderer());
    }

    /** @test */
    public function itLoadsTheHomePage(): void
    {
        $response = $this->controller
            ->getResponse(
                new RequestData(
                    '/',
                    new RequestMethod(RequestMethod::METHOD_GET)
                )
            )
        ;
        \ob_start();
        $response->send();
        $actual = (string)\ob_get_clean();
        self::assertStringContainsString('</html>', $actual);
    }
}
