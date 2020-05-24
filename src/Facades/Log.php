<?php

namespace hollisho\lumensls\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static void emergency(string $message, array $context = [])
 * @method static void alert(string $message, array $context = [])
 * @method static void critical(string $message, array $context = [])
 * @method static void error(string $message, array $context = [])
 * @method static void warning(string $message, array $context = [])
 * @method static void notice(string $message, array $context = [])
 * @method static void info(string $message, array $context = [])
 * @method static void debug(string $message, array $context = [])
 * @method static void log($level, string $message, array $context = [])
 * @method static mixed channel(string $channel = null)
 * @method static \Psr\Log\LoggerInterface stack(array $channels, string $channel = null)
 *
 * @see \hollisho\lumensls\SLSLogWriter
 */
class Log extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'sls.writer';
    }
}