<?php

declare(strict_types=1);

const BASE_DIR = '/tmp/iterator-fun/';

echo "
First we have a recursive function that will remove a nested directory that contains files.
 
This  is used to clean up from any previous run
";

function recursiveRemoveDir(string $path): void
{
    $traversable = new \FilesystemIterator(
        $path,
        flags: \FilesystemIterator::CURRENT_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS
    );
    $items       = iterator_to_array($traversable, false);
    $items       = array_reverse($items);
    foreach ($items as $item) {
        if (is_dir($item)) {
            recursiveRemoveDir($item);
            rmdir($item);
        }
        if (is_file($item)) {
            unlink($item);
        }
    }
}

recursiveRemoveDir(BASE_DIR);

mkdir(directory: BASE_DIR . 'foo/bar/baz', permissions: 0777, recursive: true);
mkdir(directory: BASE_DIR . 'boo/far/faz', permissions: 0777, recursive: true);

$directoryIterator = new RecursiveDirectoryIterator(directory: BASE_DIR);
$iteratorIterator  = new RecursiveIteratorIterator(
    $directoryIterator,
    mode: RecursiveIteratorIterator::SELF_FIRST
);
/** @var SplFileInfo $i */
$toggle  = false;
$visited = [];
foreach ($iteratorIterator as $i) {
    $path = $i->getRealPath();
    if (isset($visited[$path])) {
        continue;
    }
    $visited[$path] = true;
    if (false === str_starts_with(haystack: $path, needle: BASE_DIR)) {
        continue;
    }
    if (false === $i->isDir()) {
        continue;
    }
    echo "$path\n";
    $prefix = ($toggle = !$toggle) ? 'blue_' : 'green_';
    tempnam($path, $prefix);
}
echo "
Tree after first recursive pass through and creating temp files:
";
passthru(sprintf("tree %s", BASE_DIR));

echo "
Now we're going to loop over the directory again using regex to pull out blue only

Notice the use of an anonymous class
";
$filterIterator = new class(
    new RecursiveIteratorIterator($directoryIterator)
) extends FilterIterator {
    public function accept(): bool
    {
        $current = $this->getCurrent();
        if ($current->isDir()) {
            return false;
        }

        return $this->isBlue(filename: $current->getBasename());
    }

    private function isBlue(string $filename)
    {
        return str_contains(haystack: $filename, needle: 'blue');
    }

    private function getCurrent(): SplFileInfo
    {
        $current = $this->current();
        if ($current instanceof SplFileInfo) {
            return $current;
        }
        throw new \RuntimeException('unexpected current value ' . var_export($current, true));
    }
};

foreach ($filterIterator as $i) {
    echo "\n " . $i->getRealPath();
}

echo "

And so ends the whistle stop tour of iterators, I hope you had fun :)

";

