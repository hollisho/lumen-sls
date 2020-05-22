<?php

namespace hollisho\lumensls\Logging;

use Monolog\Handler\BufferHandler;

class SLSFormatter
{
    /**
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        /* @var $slsLog \hollisho\lumensls\SLSLog */
        $slsLog = app('sls');
        /* @var $logger \Monolog\Logger */
        $handler = new SLSLogHandler($slsLog);
        $handler->setFormatter(new SLSLogContentFormatter());
        $logger->pushHandler(new BufferHandler($handler, 1));
    }
}