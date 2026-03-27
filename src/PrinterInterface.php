<?php

declare(strict_types=1);

namespace Exan\Pudocumenter;

interface PrinterInterface
{
    public function print(ParsedPage $page, bool $lastPage): void;
}
