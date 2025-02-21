<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SmartDato\ArcoSpedizioni\ArcoSpedizioni
 */
final class ArcoSpedizioni extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SmartDato\ArcoSpedizioni\ArcoSpedizioni::class;
    }
}
