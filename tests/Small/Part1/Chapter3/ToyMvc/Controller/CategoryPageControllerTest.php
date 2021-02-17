<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\CategoryPageController;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\FakeDataForToy;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\CategoryEntity;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;
use PHPUnit\Framework\TestCase;

/**
 * @small
 * @covers \Book\Part1\Chapter3\ToyMvc\Controller\CategoryPageController
 *
 * @internal
 */
final class CategoryPageControllerTest extends TestCase
{
    private CategoryPageController $controller;
    private CategoryEntity         $categoryEntity;

    public function setUp(): void
    {
        $this->categoryEntity = FakeDataForToy::singleton()->getCategoryEntities()[0];
        $this->controller     = new CategoryPageController($this->categoryEntity, new TemplateRenderer());
    }

    /** @test */
    public function itLoadsThePage(): void
    {
        $uri         = $this->getUri();
        $requestData = new RequestData($uri, new RequestMethod(RequestMethod::METHOD_GET));
        $response    = $this->controller->getResponse($requestData);
        ob_start();
        $response->send();
        $actual = (string)ob_get_clean();
        self::assertStringContainsString('</html>', $actual);
    }

    private function getUri(): string
    {
        $catIdString = (string)$this->categoryEntity->getUuid();

        return '/c/' . $catIdString;
    }
}
