<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\View;

use Book\Part1\Chapter3\ToyMvc\View\Data\TemplateDataInterface;

final class TemplateRenderer
{
    /**
     * This method does the work of using the template to render some actual HTML
     *
     * The data variable is available to the template which is simple PHP that is then required. The ob_ functions use
     * output buffering to capture the output of the template and then allow us ot return it as a string
     */
    public function renderTemplate(string $templateName, TemplateDataInterface $data): string
    {
        ob_start();
        require __DIR__ . '/Template/' . basename($templateName);

        return ob_get_clean();
    }
}