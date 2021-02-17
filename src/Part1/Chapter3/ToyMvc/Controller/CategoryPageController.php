<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\Response;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\CategoryRepository;
use Book\Part1\Chapter3\ToyMvc\View\Data\CategoryPageData;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;

#[Route(CategoryPageController::ROUTE_REGEX, RequestMethod::METHOD_GET)]
final class CategoryPageController implements ControllerInterface
{
    public const ROUTE_REGEX = '%^/c/(?<' . Uuid::ROUTE_MATCH_KEY . '>.+?)$%m';

    public const TEMPLATE_NAME = 'CategoryPageTemplate.php';

    public function __construct(
        private CategoryRepository $categoryRepository,
        private TemplateRenderer $templateRenderer
    ) {
    }

    public function getResponse(RequestData $requestData): Response
    {
        $uuid           = Uuid::createFromUri($requestData->getUri(), self::ROUTE_REGEX);
        $categoryEntity = $this->categoryRepository->load($uuid);
        $templateData   = new CategoryPageData($categoryEntity);
        $pageContent    = $this->templateRenderer->renderTemplate(self::TEMPLATE_NAME, $templateData);

        return new Response($pageContent);
    }
}
