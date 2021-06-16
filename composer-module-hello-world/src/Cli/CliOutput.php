<?php

declare(strict_types=1);

namespace YourName\HelloWorld\Cli;

use YourName\HelloWorld\MessageProviderInterface;
use YourName\HelloWorld\OutputInterface;

class CliOutput implements OutputInterface
{
    public function __construct()
    {
        if (PHP_SAPI !== 'cli') {
            throw new \RuntimeException('This output mechanism should only be used on the CLI');
        }
    }

    public function sendOutput(MessageProviderInterface $messageProvider): void
    {
        fwrite(STDOUT, "\n" . $messageProvider->getMessage());
    }
}