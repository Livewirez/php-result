<?php

namespace Livewirez\PhpResult;

use Throwable;
use RuntimeException;
use InvalidArgumentException;
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
        public Throwable $error,
        public mixed $data = null
    ) {
        
    }

    public function isOk(): bool
    {
        return false;
    }

    public function isErr(): bool
    {
        return true;
    }

    public function unwrap(): mixed
    {
        throw new RuntimeException('Cannot unwrap value from a Failure: ' . $this->error->getMessage());
    }

    public function unwrapErr(): mixed
    {
        return $this->error;
    }
}