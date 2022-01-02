<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return redirect()->route('errorPage')->with('searcherror','searcherror');
        });
        $this->reportable(function (Throwable $e) {
            //
        });

        // $this->renderable(function (ErrorException $e, $request) {
        //     return response()->json( [
        //                 'success' => 0,
        //                 'message' => 'Method is not allowed for the requested route',
        //             ], 405 );
        //     });
    }
}
