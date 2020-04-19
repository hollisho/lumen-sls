<?php

namespace hollisho\lumensls\Logging;

class SLSFormatter
{
    /**
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new SLSLogContentFormatter());
        }
    }
}