<?php

namespace hollisho\lumensls;

use Aliyun\SLS\Client;
use hollisho\lumensls\Console\PublishConfigCommand;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class LumenSLSServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        /* @var Application $app */
//        $app = $this->app;
//        $app->configure('sls');
    }


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

        $this->app->singleton('sls', function ($app) {
            $config = $app['config']['sls'];
            $accessKeyId     = array_get($config, 'access_key_id');
            $accessKeySecret = array_get($config, 'access_key_secret');
            $endpoint        = array_get($config, 'endpoint');
            $project         = array_get($config, 'project');
            $store           = array_get($config, 'log_store');
            $topic           = array_get($config, 'topic');
//            $env             = array_get($config, 'env');

            $client = new Client($endpoint, $accessKeyId, $accessKeySecret);

            $log = new SLSLogManager($client, $topic);
            $log->setProject($project);
            $log->setLogStore($store);

            return $log;
        });

        $config = $this->app['config']['sls'];

        $this->app->instance('sls.writer', new SLSLogWriter(app('sls'), $this->app['events'], $config['topic'], $config['env']));
    }
}
