<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3;

use Book\Part1\Chapter3\ToyMVC\BrowserVisit;

require __DIR__ . '/../../../vendor/autoload.php';

$homePage = (new BrowserVisit())->visit('/');

echo $homePage;
