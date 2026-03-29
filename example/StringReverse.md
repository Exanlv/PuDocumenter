## String reverse

Reversing a string isn't, but I tend to use it as a mock implementation for some kind of hashing.

### Using strrev()
As you can see, there's a built-in PHP function to reverse a string!
```php
$myVar = 'test-value';

$myVar = strrev($myVar);

// And now it's reversed! Wow!
static::assertEquals('eulav-tset', $myVar);
```

### Doing it manually
Of course we can also do it like this!
```php
$myVar = 'test-value';
$reversed = '';

// Use a for loop to iterate through each character 1 by 1
for ($i = strlen($myVar) - 1; $i >= 0; $i--) {
    $reversed .= $myVar[$i];
}

// And now this too, is reversed!
static::assertEquals('eulav-tset', $reversed);
```
