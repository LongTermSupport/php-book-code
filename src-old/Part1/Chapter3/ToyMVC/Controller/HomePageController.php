<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMVC\Controller;

use Book\Part1\Chapter3\ToyMVC\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMVC\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMVC\Controller\Data\Response;
use Book\Part1\Chapter3\ToyMVC\Meta\Route;
use Book\Part1\Chapter3\ToyMVC\Model\Repository\CategoryRepository;
use Book\Part1\Chapter3\ToyMVC\View\Data\HomePageData;
use Book\Part1\Chapter3\ToyMVC\View\TemplateRenderer;

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
        $collection   = $this->categoryRepository->loadAll();
        $templateData = new HomePageData($collection);
        $pageContent  =
            $this->templateRenderer->renderTemplate(
                self::TEMPLATE_NAME,
                $templateData
            );

        return new Response($pageContent);
    }
}
