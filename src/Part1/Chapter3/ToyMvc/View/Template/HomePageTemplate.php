<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\View\Template;

use Book\Part1\Chapter3\ToyMvc\View\Data\HomePageData;
use Book\Part1\Chapter3\ToyMvc\View\Esc;

// Note this one line of DocBlock allows all of the code in this template to be statically analysed
// and allows our IDE to autocomplete all method calls etc for us
/* @var $templateData HomePageData */

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
</head>
<body>
<h1>Categories</h1>
<ul>
    <?php foreach ($templateData->getCategoryCollection() as $catId => $category) { ?>
        <li><a href="/c/<?php echo $catId; ?>"><?php echo Esc::_($category->getName()); ?></a>
            <ol>
                <?php foreach ($category->getPostCollection() as $postId => $post) { ?>
                    <li><a href="/p/<?php echo $postId; ?>"><?php echo Esc::_($post->getTitle()); ?></a></li>
                <?php } ?>
            </ol>
        </li>
    <?php } ?>
</ul>
</body>
</html>