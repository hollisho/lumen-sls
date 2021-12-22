<?php

namespace hollisho\lumensls\Logging;

use Monolog\Handler\BufferHandler;
use Monolog\Logger;

class SLSFormatter
{
    /**
     * @author Hollis Ho <he_wenzhi@126.com>
     * @param $logger
     * @param int $bufferLimit
     * @param int $level
     * @param bool $bubble
     * @param bool $flushOnOverflow
     */
    public function __invoke($logger, $bufferLimit = 0, $level = Logger::DEBUG, $bubble = true, $flushOnOverflow = true)
    {
        /* @var $slsLog \hollisho\lumensls\SLSLogManager */
        $slsLog = app('sls');
        /* @var $logger \Monolog\Logger */
        $handler = new SLSLogHandler($slsLog, config('sls.log_store'));
        $handler->setFormatter(new SLSLogContentFormatter());
        $logger->pushHandler(new BufferHandler($handler, $bufferLimit, $level, (bool) $bubble, (bool) $flushOnOverflow));
    }
}
