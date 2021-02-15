<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\Controller\PostPageController;
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
final class PostPageControllerTest extends TestCase
{
    /** @test */
    public function itLoadsThePage(): void
    {
        $uri         = $this->getUri();
        $requestData = new RequestData($uri, new RequestMethod(RequestMethod::METHOD_GET));
        $uriMatches  = $this->getUriMatches($requestData);
        $response    = PostPageController::create($uriMatches)->getResponse($requestData);
        ob_start();
        $response->send();
        $actual = (string)ob_get_clean();
        self::assertStringContainsString('</html>', $actual);
    }

    private function getUri(): string
    {
        $postEntity = current(FakeDataForToy::singleton()->getPostEntities());
        if ($postEntity === false) {
            throw new RuntimeException('Failed getting post entity');
        }
        $postId = (string)$postEntity->getUuid();

        return '/p/' . $postId;
    }

    /**
     * @return array<mixed,string>
     */
    private function getUriMatches(RequestData $requestData): array
    {
        $route = new Route(PostPageController::ROUTE_REGEX, RequestMethod::METHOD_GET);
        if ($route->isMatch($requestData) === false) {
            throw new RuntimeException('Failed matching URI ' . $requestData->getUri());
        }

        return $route->getMatchGroups();
    }
}
