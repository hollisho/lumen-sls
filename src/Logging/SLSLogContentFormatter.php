<?php

namespace hollisho\lumensls\Logging;


use Monolog\Formatter\LineFormatter;

class SLSLogContentFormatter extends LineFormatter
{
    public function format(array $record)
    {
        $level = array_get($record, 'level_name', 'info');
        $channel = array_get($record, 'channel');
        $message = array_get($record, 'message', '');
        $context = array_get($record, 'context', []);
        $datetime = array_get($record, 'datetime');
        $datetime = $datetime->format('Y-m-d H:i:s');
        app('sls')->putLogs([
            'level' => $level,
            'env' => $channel,
            'message' => $message,
            'context' => json_encode($context),
            'datetime' => $datetime,
            'request' => json_encode(self::getRequest())
        ]);
        return $record;
    }

    public static function getRequest() {
        return [
            '_GET' => $_GET,
            '_POST' => $_POST,
            '_COOKIE' => $_COOKIE,
            '_HEADER' => getallheaders(),
            '_BODY' => @file_get_contents('php://input')
        ];
    }
}