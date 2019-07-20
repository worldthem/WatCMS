<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
          
            $getExceptions = get_class($exception);
         // echo  $getExceptions;
          if($exception instanceof ModelNotFoundException or $exception instanceof NotFoundHttpException)
            {
                return response()->view('standart.404', ['error'=>$exception, 'errorType'=>'404'], 500);
             }elseif($getExceptions == 'Illuminate\Auth\AuthenticationException'){
                return parent::render($request, $exception);
            }elseif($getExceptions == 'Symfony\Component\Debug\Exception\FatalThrowableError'){
                   $debug = config('app.debug');
               if(!$debug) {
                   return response()->view('standart.404', ['error'=>$exception, 'errorType'=>'503'], 500);
               }
            }
            
           return parent::render($request, $exception);
    }
}
