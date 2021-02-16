<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc;

use Book\Part1\Chapter3\ToyMvc\Controller\ControllerFactory;
use Book\Part1\Chapter3\ToyMvc\Controller\ControllerInterface;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\RequestDataFactory;


final class FrontController
{
    public function __construct(
        private ControllerFactory $controllerFactory,
        private RequestDataFactory $requestDataFactory
    ) {
    }

    public function handleRequest(): void
    {
        $requestData = $this->requestDataFactory::createFromGlobals();
        $this->createController($requestData)
             ->getResponse($requestData)
             ->send();
    }

    private function createController(RequestData $requestData): ControllerInterface
    {
        return $this->controllerFactory->createControllerForRequest($requestData);
    }
}
