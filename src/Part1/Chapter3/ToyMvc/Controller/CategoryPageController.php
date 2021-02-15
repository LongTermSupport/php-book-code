<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\Response;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\CategoryEntity;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;
use Book\Part1\Chapter3\ToyMvc\Model\Repository\CategoryRepository;
use Book\Part1\Chapter3\ToyMvc\View\Data\CategoryPageData;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;

#[Route(CategoryPageController::ROUTE_REGEX, RequestMethod::METHOD_GET)]
final class CategoryPageController implements ControllerInterface
{
    public const ROUTE_REGEX = <<<'REGEXP'
        %^/c/(?<id>.+?)$%m
        REGEXP;

    public const TEMPLATE_NAME = 'CategoryPageTemplate.php';

    public function __construct(
        private CategoryEntity $categoryEntity,
        private TemplateRenderer $templateRenderer
    ) {
    }

    /** @param array<mixed,string> $uriMatches */
    public static function create(array $uriMatches): static
    {
        $categoryId = new Uuid($uriMatches['id']);

        return new self(
            (new CategoryRepository())->load($categoryId),
            new TemplateRenderer()
        );
    }

    public function getResponse(RequestData $requestData): Response
    {
        $data        = new CategoryPageData($this->categoryEntity);
        $pageContent = $this->templateRenderer->renderTemplate(self::TEMPLATE_NAME, $data);

        return new Response($pageContent);
    }
}
