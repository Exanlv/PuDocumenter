<?php

declare(strict_types=1);

namespace Tests;

use Exan\Pudocumenter\Attributes\Example;
use Exan\Pudocumenter\Attributes\Page;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[Page('String reverse')]
class StringReverseTest extends TestCase
{
    #[Example(
        'Using strrev()',
        'As you can see, there\'s a built-in PHP function to reverse a string!'
    )]
    #[Test]
    public function it_can_use_strrev()
    {
        $myVar = 'test-value';

        $myVar = strrev($myVar);

        // And now it's reversed! Wow!
        static::assertEquals('eulav-tset', $myVar);
    }

    #[Example(
        'Doing it manually',
        'Of course we can also do it like this!'
    )]
    #[Test]
    public function it_can_do_it_manually()
    {


        $myVar = 'test-value';
        $reversed = '';

        // Use a for loop to iterate through each character 1 by 1
        for ($i = strlen($myVar) - 1; $i >= 0; $i--) {
            $reversed .= $myVar[$i];
        }

        // And now this too, is reversed!
        static::assertEquals('eulav-tset', $reversed);

        // @hide

    }
}
