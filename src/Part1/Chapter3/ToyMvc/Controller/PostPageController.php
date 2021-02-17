<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\Response;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\PostRepository;
use Book\Part1\Chapter3\ToyMvc\View\Data\PostPageData;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;

#[Route(PostPageController::ROUTE_REGEX, RequestMethod::METHOD_GET)]
final class PostPageController implements ControllerInterface
{
    public const ROUTE_REGEX = '%^/p/(?<' . Uuid::ROUTE_MATCH_KEY . '>.+?)$%m';

    public const TEMPLATE_NAME = 'PostPageTemplate.php';

    public function __construct(
        private PostRepository $postRepository,
        private TemplateRenderer $templateRenderer
    ) {
    }

    public function getResponse(RequestData $requestData): Response
    {
        $uuid         = Uuid::createFromUri($requestData->getUri(), self::ROUTE_REGEX);
        $postEntity   = $this->postRepository->load($uuid);
        $templateData = new PostPageData($postEntity);
        $pageContent  = $this->templateRenderer->renderTemplate(self::TEMPLATE_NAME, $templateData);

        return new Response($pageContent);
    }
}
