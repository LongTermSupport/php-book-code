<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\FrontController;

require __DIR__ . '/../../../vendor/autoload.php';

$_SERVER['REQUEST_URI']    = '/';
$_SERVER['REQUEST_METHOD'] = 'GET';

$requestData     = new RequestData(
    $_SERVER['REQUEST_URI'],
    new RequestMethod($_SERVER['REQUEST_METHOD'])
);
$frontController = new FrontController();
$frontController->getController($requestData)
                ->getResponse($requestData)
                ->send();
