<?php

declare(strict_types=1);

namespace Book\Part4\Chapter10;

use Book\Part4\Chapter10\Dependencies\ClassOne;
use Book\Part4\Chapter10\Dependencies\ClassTwo;
use RuntimeException;

/*
 * We call spl_autoload_register and pass in our bespoke closure which handles autoloading.
 */
\spl_autoload_register(static function (string $classFqn): bool {
    $offset = \strrchr($classFqn, '\\');
    if ($offset === false) {
        throw new RuntimeException('Failed finding \\ in $classFqn ' . $classFqn);
    }
    $className = \substr($offset, 1);
    $path      = __DIR__ . '/Dependencies/' . $className . '.php';
    if (!\file_exists($path)) {
        throw new RuntimeException('Unable to find file for class: ' . $className);
    }
    include $path;

    return true;
});

/**
 * And we can then freely refer to classes without any messy work to locate and require PHP files.
 */
$class = new ClassTwo(new ClassOne());
