# PU Documenter

Easy way to turn tests into documentation.

CI/CD, Continuous Integration / Continuous Documentation

# Usage


```sh
composer require exan/pudocumenter
```

```php
use Exan\Pudocumenter\Documenter;
use Exan\Pudocumenter\StdOutMarkdownPrinter;
use Tests\StringReverseTest;

require './vendor/autoload.php';

$documenter = new Documenter(
    StringReverseTest::class,
    // Or add more classes...
);

$documenter->document(new StdOutMarkdownPrinter);
```
