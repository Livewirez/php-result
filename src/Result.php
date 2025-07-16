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