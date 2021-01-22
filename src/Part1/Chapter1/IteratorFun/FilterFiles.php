<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\IteratorFun;

use FilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class FilterFiles
{
    /** @return SplFileInfo[] */
    public function getFilteredFiles(Config $config, string $filterMatch): array
    {
        $filterIterator = $this->getIterator($config);

        return iterator_to_array($filterIterator);
    }

    /** @return FilterIterator */
    private function getIterator(Config $config): FilterIterator
    {
        $directoryIterator = new RecursiveDirectoryIterator(directory: $config->getBaseDir());

        return new class(new RecursiveIteratorIterator($directoryIterator)) extends FilterIterator {
            public function accept(): bool
            {
                $current = $this->current();
                if ($current->isDir()) {
                    return false;
                }

                return $this->isBlue(filename: $current->getBasename());
            }

            private function isBlue(string $filename): bool
            {
                return str_contains(haystack: $filename, needle: 'blue');
            }
        };
    }
}
