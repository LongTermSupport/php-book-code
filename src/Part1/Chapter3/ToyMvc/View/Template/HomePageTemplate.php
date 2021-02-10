<?php

declare(strict_types=1);

use Book\Part1\Chapter3\ToyMvc\View\Data\HomePageData;
use Book\Part1\Chapter3\ToyMvc\View\Esc;

/** @var $data HomePageData */

?>
<html>
<head>
    <title>Home Page</title>
</head>
<body>
<h1>Categories</h1>
<ul>
    <?php foreach ($data->getCategoryCollection()->getCategoryEntities() as $category): ?>
        <li><?= Esc::_($category->getName()) ?>
            <ol>
                <?php foreach ($category->getPostCollection()->getPostEntities() as $post): ?>
                    <li><?= Esc::_($post->getTitle()) ?></li>
                <?php endforeach; ?>
            </ol>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>