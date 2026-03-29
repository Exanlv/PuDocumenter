<?php

declare(strict_types=1);

namespace Exan\Pudocumenter;

readonly class ParsedPage
{
    /**
     * @param string $title
     * @param ParsedExample[] $examples
     */
    public function __construct(
        public string $title,
        public ?string $description,
        public array $examples,
    ) {
    }
}
