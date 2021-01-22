<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1\IteratorFun;

use SplFileInfo;

trait CurrentIsFileInfoTrait
{
    public function getCurrent(): SplFileInfo
    {
        $current = parent::current();
        if ($current instanceof SplFileInfo) {
            return $current;
        }
        throw new \RuntimeException('unexpected current value ' . var_export($current, true));
    }
}