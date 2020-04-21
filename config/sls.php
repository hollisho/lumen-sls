<?php
return [
    'access_key_id'     => env('ALI_LOGSTORE_ACCESS_KEY_ID'),
    'access_key_secret' => env('ALI_LOGSTORE_ACCESS_KEY_SECRET'),
    /**
     * https://help.aliyun.com/document_detail/29008.html
     */
    'endpoint'          => env('ALI_LOGSTORE_ENDPOINT'),
    'project'           => env('ALI_LOGSTORE_PROJECT_NAME'),
    'log_store'             => env('ALI_LOGSTORE_NAME', 'lumen_sls_log'),
    'topic'             => env('APP_NAME'),
    'env'             => env('APP_ENV'),
];
