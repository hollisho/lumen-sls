<?php

namespace hollisho\lumensls\Logging;


use hollisho\lumensls\SLSLogManager;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class SLSLogHandler extends AbstractProcessingHandler
{
    /* @var $logger SLSLogManager */
    protected $logger;

    protected $logStore;
    /**
     * {@inheritdoc}
     */
    public function __construct(SLSLogManager $logger, $logStore = null, int $level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->logger = $logger;
        $this->logStore = $logStore;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultFormatter()
    {
        return new SLSLogContentFormatter();
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->send($record['formatted']);
    }

    /**
     * {@inheritdoc}
     */
    public function handleBatch(array $records)
    {
        $messages = array();

        foreach ($records as $record) {
            if ($record['level'] < $this->level) {
                continue;
            }
            $messages[] = $this->processRecord($record);
        }

        if (!empty($messages)) {
            $this->send($this->getFormatter()->formatBatch($messages));
        }
    }


    /**
     * Processes a record.
     *
     * @param  array $record
     * @return array
     */
    protected function processRecord(array $record)
    {
        if ($this->processors) {
            foreach ($this->processors as $processor) {
                $record = call_user_func($processor, $record);
            }
        }

        return $record;
    }

    /**
     * {@inheritdoc}
     */
    protected function send(array $contents)
    {
        if($contents) foreach ($contents as $content) {
            $this->logger->putLogs($content, $this->logStore);
        }
    }

}