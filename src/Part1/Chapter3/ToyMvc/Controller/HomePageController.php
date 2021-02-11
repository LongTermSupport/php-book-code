<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Controller;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\Response;
use Book\Part1\Chapter3\ToyMvc\Meta\Route;
use Book\Part1\Chapter3\ToyMvc\View\Data\HomePageData;

#[Route(HomePageController::ROUTE_REGEX, RequestMethod::METHOD_GET)]
class HomePageController implements ControllerInterface
{
    public const ROUTE_REGEX = <<<'REGEXP'
%^/$%m
REGEXP;

    public function __construct()

    public function getResponse(RequestData $requestData): Response
    {
        $data=new HomePageData()
    }
}