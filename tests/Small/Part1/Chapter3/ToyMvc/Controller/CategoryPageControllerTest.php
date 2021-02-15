<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\CategoryPageController;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\FakeDataForToy;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @small
 * @covers \Book\Part1\Chapter3\ToyMvc\Controller\CategoryPageController
 *
 * @internal
 */
final class CategoryPageControllerTest extends TestCase
{
    /** @test */
    public function itLoadsThePage(): void
    {
        $uri         = $this->getUri();
        $requestData = new RequestData($uri, new RequestMethod(RequestMethod::METHOD_GET));
        $uriMatches  = $this->getUriMatches($requestData);
        $response    = CategoryPageController::create($uriMatches)->getResponse($requestData);
        ob_start();
        $response->send();
        $actual = (string)ob_get_clean();
        self::assertStringContainsString('</html>', $actual);
    }

    private function getUri(): string
    {
        $catId = (string)FakeDataForToy::singleton()->getCat1Id();

        return '/c/' . $catId;
    }

    /**
     * @return array<mixed,string>
     */
    private function getUriMatches(RequestData $requestData): array
    {
        $route = new Route(CategoryPageController::ROUTE_REGEX, RequestMethod::METHOD_GET);
        if ($route->isMatch($requestData) === false) {
            throw new RuntimeException('Failed matching URI ' . $requestData->getUri());
        }

        return $route->getMatchGroups();
    }
}
