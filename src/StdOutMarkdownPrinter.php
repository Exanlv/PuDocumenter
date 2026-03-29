<?php

declare(strict_types=1);

namespace Exan\Pudocumenter;

class StdOutMarkdownPrinter implements PrinterInterface
{
    public function print(ParsedPage $page, bool $lastPage): void
    {
        echo '## ', $page->title, PHP_EOL;
        echo PHP_EOL;

        if ($page->description !== null) {
            echo $page->description, PHP_EOL, PHP_EOL;
        }


        $totalExamples = count($page->examples);
        foreach ($page->examples as $i => $example) {
            if ($example->title !== null) {
                echo '### ' . $example->title, PHP_EOL;
            }
            if ($example->description !== null) {
                echo $example->description, PHP_EOL;
            }
            echo '```php', PHP_EOL;
            echo $example->code, PHP_EOL;
            echo '```', PHP_EOL;

            if ($totalExamples !== ($i + 1) || !$lastPage) {
                echo PHP_EOL;
            }
        }

        if (!$lastPage) {
            echo '---', PHP_EOL, PHP_EOL;
        }
    }
}
