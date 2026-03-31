<?php

declare(strict_types=1);

namespace Exan\Pudocumenter;

class StdOutMarkdownTOCPrinter implements PrinterInterface
{
    public function print(ParsedPage $page, bool $lastPage): void
    {
        echo ' - [', $page->title, '](', $this->getLink($page->title), ')', PHP_EOL;

        foreach ($page->examples as $example) {
            if ($example->title === null) {
                continue;
            }

            echo '     - [', $example->title, '](', $this->getLink($example->title), ')', PHP_EOL;
        }
    }

    private function getLink(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s]+/', '-', $text);
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');

        return '#' . $text;
    }
}
