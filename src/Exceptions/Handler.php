<?php

namespace hollisho\lumensls\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use xbull\lumen\struct\Traits\JsonResponse;

class Handler extends \Laravel\Lumen\Exceptions\Handler
{
    private $code = -1;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
        $code = $exception->getCode() && is_numeric($exception->getCode()) ? $exception->getCode() : $this->code;
        /* @var \Illuminate\Http\Request  $request */
        $request = app('request');
        /* @var $slsLog \hollisho\lumensls\SLSLogManager */
        $slsLog = app('sls');
        $slsLog->setLogStore('xbull_exception_log')->putLogs([
            'datetime' => date('Y-m-d H:i:s'),
            'env' => trim(env('APP_ENV')),
            'route' => json_encode(app('request')->route()),
            'request' => json_encode($request->toArray()),
            'header' => json_encode($request->header()),
            'code' => $code,
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'line' => $exception->getLine(),
            'file' => $exception->getFile(),
            'uri' => $request->getRequestUri(),
            'method' => $request->getMethod()
        ]);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return response()->json([
            'status' => -1,
            'data' => null,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode() ? $exception->getCode() : $this->code
        ]);

    }

    public function isInvalid($code): bool
    {
        return $code < 100 || $code >= 600;
    }
}
