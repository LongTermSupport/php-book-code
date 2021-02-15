<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\View\Template;

use Book\Part1\Chapter3\ToyMvc\View\Data\CategoryPageData;
use Book\Part1\Chapter3\ToyMvc\View\Esc;

/** @var CategoryPageData $data */
$category = $data->getCategory();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Category <?php echo Esc::_($category->getName()); ?></title>
</head>
<body>
<h1><?php echo Esc::_($category->getName()); ?></h1>
<ul>
    <ul>
        <?php foreach ($category->getPostCollection() as $postId => $post) { ?>
            <li><a href="/p/<?php echo $postId; ?>"><?php echo Esc::_($post->getTitle()); ?></a></li>
        <?php } ?>
    </ul>
</body>
</html>