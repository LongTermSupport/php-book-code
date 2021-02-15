<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyMvc\View;

use Book\Part1\Chapter3\ToyMvc\Model\Repository\CategoryRepository;
use Book\Part1\Chapter3\ToyMvc\View\Data\CategoryPageData;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;
use PHPUnit\Framework\TestCase;

/**
 * @small
 * @covers \Book\Part1\Chapter3\ToyMvc\View\Data\CategoryPageData
 * @covers \Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer
 *
 * @internal
 */
final class CategoryPageTemplateTest extends TestCase
{
    public const TEMPLATE_NAME = 'CategoryPageTemplate.php';

    public const MATCHES_FORMAT = <<<'HTML'
        <!DOCTYPE html>
        <html>
          <head>
            <title>
              Category Category 1
            </title>
          </head>
          <body>
            <h1>
              Category 1
            </h1>
            <ul>
              <ul>
                <li>
                  <a href="/p/%s">Post 1</a>
                </li>
                <li>
                  <a href="/p/%s">Post 2</a>
                </li>
              </ul>
            </ul>
          </body>
        </html>
        HTML;

    /** @test */
    public function itRendersTheHomePage(): void
    {
        $collection  = (new CategoryRepository())->loadAll();
        $data        = new CategoryPageData($collection->current());
        $pageContent = (new TemplateRenderer())->renderTemplate(self::TEMPLATE_NAME, $data);
        self::assertStringMatchesFormat(self::MATCHES_FORMAT, $pageContent);
    }
}
