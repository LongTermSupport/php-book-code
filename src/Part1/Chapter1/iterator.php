<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1;

use Book\Part1\Chapter1\IteratorFun\Config;
use Book\Part1\Chapter1\IteratorFun\DirectoryRemover;
use Book\Part1\Chapter1\IteratorFun\FileCreator;
use Book\Part1\Chapter1\IteratorFun\FilterBlueFiles;
use RuntimeException;

require __DIR__ . '/../../../vendor/autoload.php';

const TMP_DIR = __DIR__ . '/../../../var/';
if (!is_dir(TMP_DIR) && mkdir(TMP_DIR, 0777, true) && !is_dir(TMP_DIR)) {
    throw new RuntimeException(sprintf('Directory "%s" was not created', TMP_DIR));
}

$config = new Config(TMP_DIR . '/iterator-fun', 'foo/bar/baz', 'doo/dar/daz');

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
 * Now we're going to loop over the directory again using a filter to pull out blue only.
 */
$files = (new FilterBlueFiles())->getFilteredFiles($config);
echo "\nFiltered Blue Files:\n";
foreach ($files as $i) {
    echo "\n " . $i->getRealPath();
}
