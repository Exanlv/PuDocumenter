<?php

declare(strict_types=1);

namespace Exan\Pudocumenter;

readonly class ParsedExample
{
    public function __construct(
        public string $title,
        public string $description,
        public string $code,
    ) {
    }
}
