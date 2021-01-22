<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\IteratorFun;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class FileCreator
{
    private bool $toggle = false;
    /** @var bool[] */
    private array $visited;

    private function makeDirs(Config $config): void
    {
        foreach ($config->getSubDirs() as $subDir) {
            $this->makeDir($subDir);
        }
    }

    /**
     * First we create our working directories
     * Then we loop over our iterator and create a file in each nested directory
     * We include some sanity checks to ensure that we don't hit the same directory twice, and that we don't wander
     * outside the base directory for any reason
     *
     * Our return value is an array of the paths to all the files that we have created
     *
     * @return string[]
     */
    public function createNestedFiles(Config $config): array
    {
        $this->makeDirs($config);
        $created = [];
        foreach ($this->getIterator($config) as $fileInfo) {
            /** @var SplFileInfo $fileInfo */
            if (true === $this->visited($fileInfo)) {
                continue;
            }
            if (false === $this->valid($fileInfo, $config)) {
                continue;
            }
            $created[] = $this->createFile($fileInfo);
        }

        return $created;
    }

    /**
     * As we are actively creating files, it can cause us to hit the same path multiple times
     * This check ensures we only hit a single directory once
     */
    private function visited(SplFileInfo $fileInfo): bool
    {
        $path = $fileInfo->getPathname();
        if (isset($this->visited[$path])) {
            return true;
        }
        $this->visited[$path] = true;

        return false;
    }

    /**
     * We check to confirm the file is in the right place and also that it is a directory
     */
    private function valid(SplFileInfo $fileInfo, Config $config): bool
    {
        return str_starts_with(haystack: $fileInfo->getPathname(), needle: $config->getBaseDir())
               && true === $fileInfo->isDir();
    }

    /**
     * We create a file in the specifified directory path
     * with a known prefix of blue/green and then some random characters
     */
    private function createFile(SplFileInfo $fileInfo): string
    {
        $path   = $fileInfo->getPathname();
        $prefix = ($this->toggle = !$this->toggle) ? 'blue_' : 'green_';

        $filename = tempnam($path, $prefix);
        if (false === $filename) {
            throw new \RuntimeException('Failed creating file at ' . $path);
        }

        return $filename;
    }

    /**
     * @return RecursiveIteratorIterator<RecursiveDirectoryIterator>
     */
    private function getIterator(Config $config): RecursiveIteratorIterator
    {
        $directoryIterator = new RecursiveDirectoryIterator(directory: $config->getBaseDir());

        /**
         * The SELF_FIRST flag means that we list the directory and then the files in there.
         */
        return new \RecursiveIteratorIterator(
            $directoryIterator,
            mode: \RecursiveIteratorIterator::SELF_FIRST
        );
    }

    private function makeDir(string $path): void
    {
        if (!mkdir($path, 0777, true) &&
            !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }
}