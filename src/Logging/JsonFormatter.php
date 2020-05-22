<?php

namespace hollisho\lumensls\Logging;


class JsonFormatter extends \Monolog\Formatter\JsonFormatter
{
    public function format(array $record)
    {
        $level = array_get($record, 'level_name', 'info');
        $channel = array_get($record, 'channel');
        $message = array_get($record, 'message', '');
        $context = array_get($record, 'context', []);
        $datetime = array_get($record, 'datetime');
        $datetime = $datetime->format('Y-m-d H:i:s');
        $json = $this->toJson($this->normalize(array_merge([
                'time' => $datetime,
                'message' => $message,
                'level' => $level,
                'channel' => $channel,
            ], $context)), true) . ($this->appendNewline ? "\n" : '');

        return $json;
    }
}
