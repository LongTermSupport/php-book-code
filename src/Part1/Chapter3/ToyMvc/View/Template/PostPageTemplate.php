<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\View\Template;

use Book\Part1\Chapter3\ToyMvc\View\Data\PostPageData;
use Book\Part1\Chapter3\ToyMvc\View\Esc;

/** @var PostPageData $data */
$post = $data->getPost();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Post <?php echo Esc::_($post->getTitle()); ?></title>
</head>
<body>
<h1><?php echo Esc::_($post->getTitle()); ?></h1>
<?php echo Esc::_($post->getContentHtml()); ?>
</body>
</html>