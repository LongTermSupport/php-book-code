<?php

declare(strict_types=1);

namespace Book\Tests\Small\Part1\Chapter3\ToyMvc\View;

use Book\Part1\Chapter3\ToyMvc\Model\Repository\CategoryRepository;
use Book\Part1\Chapter3\ToyMvc\View\Data\HomePageData;
use Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer;
use PHPUnit\Framework\TestCase;

/**
 * @small
 * @covers \Book\Part1\Chapter3\ToyMvc\View\Data\HomePageData
 * @covers \Book\Part1\Chapter3\ToyMvc\View\TemplateRenderer
 *
 * @internal
 */
final class HomePageTemplateTest extends TestCase
{
    public const TEMPLATE_NAME = 'HomePageTemplate.php';

    public const MATCHES_FORMAT = <<<'HTML'
        <!DOCTYPE html>
        <html>
          <head>
            <title>
              Home Page
            </title>
          </head>
          <body>
            <h1>
              Categories
            </h1>
            <ul>
              <li>
                <a href="/c/%s">Category 1</a>
                <ol>
                  <li>
                    <a href="/p/%s">Post 1</a>
                  </li>
                  <li>
                    <a href="/p/%s">Post 2</a>
                  </li>
                </ol>
              </li>
              <li>
                <a href="/c/%s">Category 2</a>
                <ol>
                  <li>
                    <a href="/p/%s">Post 3</a>
                  </li>
                  <li>
                    <a href="/p/%s">Post 4</a>
                  </li>
                </ol>
              </li>
            </ul>
          </body>
        </html>
        HTML;

    /** @test */
    public function itRendersTheHomePage(): void
    {
        $collection  = (new CategoryRepository())->loadAll();
        $data        = new HomePageData($collection);
        $pageContent = (new TemplateRenderer())->renderTemplate(self::TEMPLATE_NAME, $data);
        self::assertStringMatchesFormat(self::MATCHES_FORMAT, $pageContent);
    }
}
