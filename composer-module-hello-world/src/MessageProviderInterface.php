<?php

declare(strict_types=1);

namespace YourName\HelloWorld;

interface MessageProviderInterface
{
    public function setLanguage(Language $language);

    /**
     * Get the hello world message in the configured Language
     */
    public function getMessage(): string;
}