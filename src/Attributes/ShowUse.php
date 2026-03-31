<?php

declare(strict_types=1);

namespace Exan\Pudocumenter\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
readonly class ShowUse
{
    public function __construct(
        public string $class,
    ) {
    }
}
