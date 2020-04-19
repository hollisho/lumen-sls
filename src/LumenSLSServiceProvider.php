<?php

namespace hollisho\lumensls;

use Aliyun\SLS\Client;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class LumenSLSServiceProvider extends ServiceProvider
{

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

            $log = new SLSLog($client, $topic);
            $log->setProject($project);
            $log->setLogStore($store);

            return $log;
        });

        $config = $this->app['config']['sls'];

        $this->app->instance('sls.writer', new Writer(app('sls'), $this->app['events'], $config['topic'], $config['env']));
    }
}
