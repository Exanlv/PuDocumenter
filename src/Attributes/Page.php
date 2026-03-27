<?php

declare(strict_types=1);

namespace Exan\Pudocumenter\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class Page
{
    public function __construct(
        public string $name
    ) {
    }
}
