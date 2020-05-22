<?php

namespace hollisho\lumensls\Logging;


use Monolog\Formatter\NormalizerFormatter;

class SLSLogContentFormatter extends NormalizerFormatter
{
    public function format(array $record)
    {
        $level = array_get($record, 'level_name', 'info');
        $channel = array_get($record, 'channel');
        $message = array_get($record, 'message', '');
        $context = array_get($record, 'context', []);
        $extra = array_get($record, 'extra', []);
        $datetime = array_get($record, 'datetime');
        $datetime = $datetime->format('Y-m-d H:i:s');
        /* @var $request \Laravel\Lumen\Http\Request */
        $request = app('request');
        $content = [
            'level' => $level,
            'env' => $channel,
            'message' => $message,
            'context' => json_encode($context),
            'extra' => json_encode($extra),
            'datetime' => $datetime,
            'request' => json_encode($request->toArray()),
            'uri' => $request->getRequestUri()
        ];

        return $content;
    }
}