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