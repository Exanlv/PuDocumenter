<?php

declare(strict_types=1);

namespace Exan\Pudocumenter;

use Exan\Pudocumenter\Attributes\Example;
use Exan\Pudocumenter\Attributes\Page;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;

class Documenter
{
    /** @var ReflectionClass[] */
    private readonly array $toDocument;

    public function __construct(
        string ...$classes
    ) {
        $this->toDocument = array_map(
            fn(string $class) => new ReflectionClass($class),
            $classes
        );
    }

    private function parseTest(ReflectionClass $reflectionClass): ParsedPage
    {
        $pages = $reflectionClass->getAttributes(Page::class);
        if (empty($pages)) {
            throw new RuntimeException('Passed class is not a documentable class');
        }

        /** @var Page */
        $page = array_shift($pages)->newInstance();

        return new ParsedPage(
            $page->name,
            $this->getExamples($reflectionClass),
        );
    }

    /** @return ParsedExample[] */
    private function getExamples(ReflectionClass $reflectionClass): array
    {
        $methods = $this->getExampleMethods($reflectionClass);

        return array_map(function (ReflectionMethod $method) use ($reflectionClass): ParsedExample {
            /** @var Example */
            $attribute = $method->getAttributes(Example::class)[0]->newInstance();

            return new ParsedExample(
                $attribute->title,
                $attribute->description,
                $this->extractCode($method, $reflectionClass),
            );
        }, $methods);
    }

    /** @return ReflectionMethod[] */
    private function getExampleMethods(ReflectionClass $reflectionClass): array
    {
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

        return array_filter($methods, fn(ReflectionMethod $method) => !empty($method->getAttributes(Example::class)));
    }

    private function extractCode(ReflectionMethod $method, ReflectionClass $reflectionClass): string
    {
        $file = $reflectionClass->getFileName();

        if ($file === false || !is_readable($file)) {
            return '';
        }

        $startLine = $method->getStartLine();
        $endLine   = $method->getEndLine();

        $length = $endLine - $startLine + 1;

        $source = file($file, FILE_IGNORE_NEW_LINES);

        if ($source === false) {
            return '';
        }

        $methodLines = array_slice($source, $startLine - 1, $length);

        return $this->cleanupFunctionCode($methodLines);
    }

    private function cleanupFunctionCode(array $lines): string
    {
        $offset = str_ends_with($lines[0], '{') ? 1 : 2;
        $bodyLines = array_slice(
            $lines,
            $offset,
            -1,
        );

        $bodyLines = array_filter($bodyLines, fn (string $line) => !str_contains($line, '// @hide'));

        $bodyLines = array_map(function (string $line) {
            if (str_starts_with($line, "\t\t")) {
                return (substr($line, 2));
            }

            if (str_starts_with($line, '        ')) {
                return (substr($line, 8));
            }

            // No other formatting is acceptable :))

            return $line;
        }, $bodyLines);

        while (reset($bodyLines) === '') {
            array_shift($bodyLines);
        }

        while (end($bodyLines) === '') {
            array_pop($bodyLines);
        }

        return implode(PHP_EOL, $bodyLines);
    }

    public function document(PrinterInterface $printer)
    {
        $total = count($this->toDocument);
        foreach ($this->toDocument as $i => $ref) {
            $page = $this->parseTest($ref);
            $printer->print($page, ($i + 1) === $total);
        }
    }
}
