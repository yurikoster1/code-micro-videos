<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
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
        $path = $request->path();
        $isAPI = preg_match('/^api/', $path);
        if ($request->wantsJson() || $isAPI) {
            $data = [];
            $erros =[];
            if (config('app.debug')) {
                $data['trace'] = $exception->getTrace();
            }
            if(method_exists($exception,'getStatusCode')){
                $status = $exception->getStatusCode();
            }else{
                $status = 400;
                if($exception instanceof AccessDeniedHttpException){
                    $status = 403;
                }
            }
            if($exception instanceof ValidationException){
                $erros = $exception->errors();
                $data = [];
            }
            $message = $exception->getMessage();
            if($exception instanceof MethodNotAllowedHttpException || $exception instanceof NotFoundHttpException){
                $message = 'Page Not Found';
                $status = 404;
            }
            //return response()->error($message,$status, $erros ,$data);
        }
        return parent::render($request, $exception);
    }
}
