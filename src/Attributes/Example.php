<?php

declare(strict_types=1);

namespace Exan\Pudocumenter\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
readonly class Example
{
    public function __construct(
        public ?string $title,
        public ?string $description,
    ) {
    }
}
