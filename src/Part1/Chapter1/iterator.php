<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1;

use Book\Part1\Chapter1\IteratorFun\Config;
use Book\Part1\Chapter1\IteratorFun\DirectoryRemover;
use Book\Part1\Chapter1\IteratorFun\FileCreator;
use Book\Part1\Chapter1\IteratorFun\FilterBlueFiles;

require __DIR__ . '/../../../vendor/autoload.php';

$config = new Config('/tmp/iterator-fun', 'foo/bar/baz', 'doo/dar/daz');

/* First we use the DirectoryRemover to clean up any previous run */
(new DirectoryRemover())->removeDir($config->getBaseDir());

/*
 * Next we recreate our directory structure
 * And we iterate through the nested structure and create a temp file in each level
 */
(new FileCreator())->createNestedFiles($config);

/*
 * Tree after first recursive pass through and creating temp files:
 * (Could have used an iterator for this as well, but I need to keep the word count down a bit!)
 */
echo "\nCreated File Tree:\n";
passthru(sprintf('tree %s', $config->getBaseDir()));

/**
 * Now we're going to loop over the directory again using a filter to pull out blue only
 * Notice the use of an anonymous class - https://www.php.net/manual/en/language.oop5.anonymous.php.
 */
$files = (new FilterBlueFiles())->getFilteredFiles($config);
echo "\nFiltered Blue Files:\n";
foreach ($files as $i) {
    echo "\n " . $i->getRealPath();
}
