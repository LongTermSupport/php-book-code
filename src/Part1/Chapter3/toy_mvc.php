<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3;

use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestData;
use Book\Part1\Chapter3\ToyMvc\Controller\Data\RequestMethod;
use Book\Part1\Chapter3\ToyMvc\FrontController;

require __DIR__ . '/../../../vendor/autoload.php';

/**
 * This little function lets us simulate a browser request to our MVC app.
 */
function visit(string $uri): string
{
    $_SERVER['REQUEST_URI']    = $uri;
    $_SERVER['REQUEST_METHOD'] = 'GET';

    $requestData     = new RequestData(
        $_SERVER['REQUEST_URI'],
        new RequestMethod($_SERVER['REQUEST_METHOD'])
    );
    $frontController = new FrontController();
    ob_start();
    $frontController->getController($requestData)
        ->getResponse($requestData)
        ->send()
    ;

    return (string)ob_get_clean();
}

$homePage = visit('/');

echo $homePage;

preg_match_all('%href="(?<uri>[^"]+)"%', $homePage, $matches);

foreach ($matches['uri'] as $uri) {
    echo "\n\n Now Visiting '{$uri}' \n\n";
    echo visit($uri);
}
