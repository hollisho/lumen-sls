<?php

namespace hollisho\lumensls;

use Aliyun\SLS\Client;
use hollisho\lumensls\Console\PublishConfigCommand;
use Illuminate\Support\ServiceProvider;

class LumenSLSServiceProvider extends ServiceProvider
{
    /**
     * Add the connector to the queue drivers.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.lumen-sls.publish-config', function () {
            return new PublishConfigCommand();
        });

        $this->commands(
            'command.lumen-sls.publish-config'
        );

        $this->app->singleton('sls', function () {
            $accessKeyId     = config('sls.access_key_id');
            $accessKeySecret = config('sls.access_key_secret');
            $endpoint        = config('sls.endpoint');
            $project         = config('sls.project');
            $store           = config('sls.log_store');
            $topic           = config('sls.topic');
//            $env             = config('sls.env');

            $log = new SLSLogManager(new Client($endpoint, $accessKeyId, $accessKeySecret), $topic);
            $log->setProject($project);
            $log->setLogStore($store);

            return $log;
        });

        $this->app->instance('sls.writer', new SLSLogWriter(app('sls'), $this->app['events'], config('sls.topic'), config('sls.env')));
    }
}
