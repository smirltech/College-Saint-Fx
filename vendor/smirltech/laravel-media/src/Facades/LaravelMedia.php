<?php

namespace SmirlTech\LaravelMedia\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SmirlTech\LaravelMedia\LaravelMedia
 */
class LaravelMedia extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SmirlTech\LaravelMedia\LaravelMedia::class;
    }
}
