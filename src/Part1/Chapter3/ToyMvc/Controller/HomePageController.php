<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\Response;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\CategoryRepository;
use Book\Part1\Chapter3\ToyMvc\View\Data\HomePageData;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;

#[Route(HomePageController::ROUTE_REGEX, RequestMethod::METHOD_GET)]
final class HomePageController implements ControllerInterface
{
    public const ROUTE_REGEX = <<<'REGEXP'
        %^/$%m
        REGEXP;

    public const TEMPLATE_NAME = 'HomePageTemplate.php';

    public function __construct(
        private CategoryRepository $categoryRepository,
        private TemplateRenderer $templateRenderer
    ) {
    }

    public function getResponse(RequestData $requestData): Response
    {
        $collection  = $this->categoryRepository->loadAll();
        $data        = new HomePageData($collection);
        $pageContent = $this->templateRenderer->renderTemplate(self::TEMPLATE_NAME, $data);

        return new Response($pageContent);
    }
}
