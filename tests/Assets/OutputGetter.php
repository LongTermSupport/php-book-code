<?php

declare(strict_types=1);

namespace Book\Tests\Assets;

class OutputGetter
{
    public static function getOutput(string $path): string
    {
        ob_start();
        try {
            require $path;
        } catch (\Throwable $throwable) {
            $output = ob_get_clean();
            throw new \RuntimeException(
                "Failed running code.\n\nOutput: $output\n\nError Message: "
                . $throwable::class . ': ' . $throwable->getMessage(),
                $throwable->getCode(),
                $throwable
            );
        }

        $output = (string)ob_get_clean();
        if (false === preg_match('%\W%', $output)) {
            throw new \RuntimeException('Got empty output');
        }

        return $output;
    }
}