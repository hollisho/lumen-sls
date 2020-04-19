# Aliyun SLS Log For Lumen


## Install

Via Composer

``` bash
$ composer require hollisho/lumen-sls
```

## Config

Add following service providers into your providers array in `bootstrap/app.php`

```php
$app->configure('sls');
$app->register(hollisho\lumensls\LumenSLSServiceProvider::class);
```

Edit your `.env` file

```bash
LOG_CHANNEL=sls

ALI_LOGSTORE_ENDPOINT=xxxxxxxx
ALI_LOGSTORE_ACCESS_KEY_ID=xxxxxxxx
ALI_LOGSTORE_ACCESS_KEY_SECRET=xxxxxxxx
ALI_LOGSTORE_PROJECT_NAME=my-project
ALI_LOGSTORE_NAME=test-store
```
You should update `ALI_LOGSTORE_ENDPOINT` to `internal endpoint` in production mode

## Usage

First create a project and store at [Aliyun SLS Console](https://sls.console.aliyun.com/)

Then update `ALI_LOGSTORE_ENDPOINT`, `ALI_LOGSTORE_PROJECT_NAME`, `ALI_LOGSTORE_NAME` in `.env`

Push a test message to queue

```php
Log::info('Test Message', ['myname'=>'hollis']);

//or you can use `app('sls')` 

app('sls')->putLogs([
	'type' => 'test',
	'message' => json_encode(['This should use json_encode'])
]);

//or you can use `SLSLog` directly 

SLSLog::putLogs([
	'type' => 'test',
	'message' => json_encode(['This should use json_encode'])
]);
```
