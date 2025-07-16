# PHP Result

![PHP Version](https://img.shields.io/packagist/php-v/livewirez/php-result)
![License](https://img.shields.io/github/license/Livewirez/webauthn-laravel)

Php version of rust's [Result](https://doc.rust-lang.org/std/result/) type which is the type used for returning and propagating errors.


## Rust

How it's defined in rust

```rust
enum Result<T, E> {
   Ok(T),
   Err(E),
}
```

## Php

How it's written in php

```php
<?php

namespace Livewirez\PhpResult;

/**
 * @template T
 * @template E
 */
interface Result
{
    /**
     * Check if the result is successful.
     * @return bool
     */
    public function isOk(): bool;

    /**
     * Check if the result is an error.
     * @return bool
     */
    public function isErr(): bool;

    /**
     * Get the success value, or throw if it's an error.
     * @return T
     * @throws \RuntimeException
     */
    public function unwrap(): mixed;

    /**
     * Get the error value, or throw if it's a success.
     * @return E
     * @throws \RuntimeException
     */
    public function unwrapErr(): mixed;
}
```

We have classes `Ok<T>` and `Err<Throwable>` that implement the `Result` interface.


## Variants

### `Ok<T>`

```php
<?php

namespace Livewirez\PhpResult;

use Throwable;
use Illuminate\Support\Traits\Macroable;

/**
 * @template T
 * @template E
 * @implements Result<T, E>
 */
final readonly class Ok implements Result
{
    use Macroable;
    
    /**
     * @param T $data
     * @param E|null $error
     */
    public function __construct(
        public readonly mixed $data,
        public readonly ?Throwable $error = null
    ) {
        if ($error !== null) {
            throw new \InvalidArgumentException('Success cannot have a non-null error.');
        }
    }

   // Other Methods
}
```

### `Err<Throwable>`

```php
namespace Livewirez\PhpResult;

use Throwable;
use Illuminate\Support\Traits\Macroable;

/**
 * @template T
 * @template E
 * @implements Result<T, E>
 */
final readonly class Err implements Result
{
    use Macroable;
    
    /**
     * @param E $error
     * @param T|null $data
     */
    public function __construct(
        public ?Throwable $error,
        public mixed $data = null
    ) {
        if ($error === null) {
            throw new \InvalidArgumentException('Failure must have a non-null error.');
        }
    }

    // Other Methods
}
```

## Helpers

The package also includes helper functions

```php
<?php 

namespace Livewirez\PhpResult;

use Throwable;
use Livewirez\PhpResult\Ok;
use Livewirez\PhpResult\Err;

function ok(mixed $data): Ok
{
    return new Ok($data);
}

function err(Throwable $error): Err
{
    return new Err($error);
}
```


## Examples

```php
function divide(int $a, int $b): Result /*<int, \Exception>*/
{
    if ($b === 0) {
        return err(new \Exception("Division by zero"));
    }
    return ok($a / $b);
}

// Test it
$result1 = divide(10, 2);
if ($result1->isOk()) {
    echo "Result: " . $result1->unwrap() . PHP_EOL; // Outputs: Result: 5
} else {
    echo "Error: " . $result1->unwrapErr()->getMessage() . PHP_EOL;
}

$result2 = divide(10, 0);
if ($result2->isOk()) {
    echo "Result: " . $result2->unwrap() . PHP_EOL;
} else {
    echo "Error: " . $result2->unwrapErr()->getMessage() . PHP_EOL; // Outputs: Error: Division by zero
}

try {
    $result2->unwrap(); // Throws exception
} catch (\RuntimeException $e) {
    // Outputs: Caught: Cannot unwrap value from a Failure: Division by zero
    echo "Caught: " . $e->getMessage() . PHP_EOL; 
}
```
