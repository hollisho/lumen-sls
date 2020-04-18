<?php

namespace hollisho\lumensls\Facades;

use Illuminate\Support\Facades\Facade;

class LogFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'sls';
    }
}