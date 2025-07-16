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

    public function isOk(): bool
    {
        return true;
    }

    public function isErr(): bool
    {
        return false;
    }

    public function unwrap(): mixed
    {
        return $this->data;
    }

    public function unwrapErr(): mixed
    {
        throw new \RuntimeException('Cannot unwrap error from a Success.');
    }
}


