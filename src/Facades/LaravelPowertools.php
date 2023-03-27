<?php

namespace Spekulatius\LaravelPowertools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spekulatius\LaravelPowertools\LaravelPowertools
 */
class LaravelPowertools extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Spekulatius\LaravelPowertools\LaravelPowertools::class;
    }
}
