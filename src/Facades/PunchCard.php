<?php

namespace TomasVotruba\PunchCard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TomasVotruba\PunchCard\PunchCard
 */
class PunchCard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TomasVotruba\PunchCard\PunchCard::class;
    }
}
