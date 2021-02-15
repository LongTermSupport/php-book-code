<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\Response;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\PostEntity;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\PostRepository;
use Book\Part1\Chapter3\ToyMvc\View\Data\PostPageData;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;

#[Route(PostPageController::ROUTE_REGEX, RequestMethod::METHOD_GET)]
final class PostPageController implements ControllerInterface
{
    public const ROUTE_REGEX = <<<'REGEXP'
        %^/p/(?<id>.+?)$%m
        REGEXP;

    public const TEMPLATE_NAME = 'PostPageTemplate.php';

    public function __construct(
        private PostEntity $postEntity,
        private TemplateRenderer $templateRenderer
    ) {
    }

    /** @param array<mixed,string> $uriMatches */
    public static function create(array $uriMatches): static
    {
        $categoryId = new Uuid($uriMatches['id']);

        return new self(
            (new PostRepository())->load($categoryId),
            new TemplateRenderer()
        );
    }

    public function getResponse(RequestData $requestData): Response
    {
        $data        = new PostPageData($this->postEntity);
        $pageContent = $this->templateRenderer->renderTemplate(self::TEMPLATE_NAME, $data);

        return new Response($pageContent);
    }
}
