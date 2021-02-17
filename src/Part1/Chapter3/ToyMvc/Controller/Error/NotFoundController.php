<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller\Error;

use Book\Part1\Chapter3\ToyMvc\Controller\ControllerInterface;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\Response;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\ResponseHeader;
use Book\Part1\Chapter3\ToyMvc\View\Data\TemplateDataInterface;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;

final class NotFoundController implements ControllerInterface
{
    public const TEMPLATE_NAME = 'NotFoundPageTemplate.php';

    public function __construct(private TemplateRenderer $templateRenderer)
    {
    }

    public function getResponse(RequestData $requestData): Response
    {
        return new Response(
            responseBody: $this->getBody(),
            headers: new ResponseHeader('404 nothing found', 404)
        );
    }

    private function getBody(): string
    {
        return $this->templateRenderer->renderTemplate(
            templateName: self::TEMPLATE_NAME,
            data: $this->getEmptyData()
        );
    }

    private function getEmptyData(): TemplateDataInterface
    {
        return new class() implements TemplateDataInterface {
        };
    }
}
