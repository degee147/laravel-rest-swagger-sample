<?php

namespace App\Exceptions;

use Throwable;
use App\Ultainfinity\Ultainfinity;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use Ultainfinity;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * Handle app error on production
     *
     * @param mixed $request
     * @param Throwable $exception
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Since it's an API, we always want json
        if (request()->expectsJson() && app()->environment('production')) {

            if ($exception instanceof ModelNotFoundException) {
                return $this->AppResponse('failed', 'Data not found', 400);
            }

            if ($exception instanceof ApiErrorException) {
                return $this->AppResponse('failed', 'Something went wrong trying to connect to Stripe');
            }

            if ($exception instanceof NotFoundHttpException) {
                return $this->AppResponse('failed', 'Oh you hit the wrong route', 404);
            }

            if ($exception instanceof HttpException) {
                return $this->AppResponse('failed', $exception->getMessage(), $exception->getStatusCode());
            }

            if (
                $exception instanceof TypeError ||
                $exception instanceof QueryException ||
                $exception instanceof InvalidArgumentException ||
                $exception instanceof FatalError ||
                $exception instanceof ErrorException
            ) {
                return $this->AppResponse('failed', 'Something is not just right, please check your data', 400);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return $this->AppResponse('failed', 'Oh maybe you hit the wrong http method', 405);
            }

            if ($exception instanceof AuthenticationException) {
                return $this->AppResponse('failed', 'Not authenticated', 401);
            }

            // if ($exception instanceof ValidationException) {
            //     return $this->AppError('failed', array_values($exception->errors())[0][0], 400);
            // }

            // return $this->AppException($exception);
        }

        return parent::render($request, $exception);
    }
}
