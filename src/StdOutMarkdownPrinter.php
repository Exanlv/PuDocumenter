<?php

declare(strict_types=1);

namespace Exan\Pudocumenter;

class StdOutMarkdownPrinter implements PrinterInterface
{
    public function print(ParsedPage $page, bool $lastPage): void
    {
        echo '## ', $page->title, PHP_EOL;
        echo PHP_EOL;

        foreach ($page->examples as $example) {
            echo '### ' . $example->title, PHP_EOL;
            echo $example->description, PHP_EOL;
            echo '```php', PHP_EOL;
            echo $example->code, PHP_EOL;
            echo '```', PHP_EOL;
            echo PHP_EOL;
        }

        if (!$lastPage) {
            echo '---', PHP_EOL;
        }
    }
}
