<?php

namespace hollisho\lumensls\Facades;

use Illuminate\Support\Facades\Facade;

class WriterFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'sls.writer';
    }
}