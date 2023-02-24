<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->notFound();
        }

        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return response()->failure(
                errorMessage: [...$e->validator->errors()->toArray()],
                statusCode: 401
            );
        }

        if ($e instanceof HttpException) {
            if ($e->getStatusCode() === 403) {
                return response()->failure(
                    statusCode: 403,
                    errorMessage: 'Forbidden! User does not have authority over this resource.'
                );
            }

            return response()->notFound();
        }

        if ($e instanceof AuthenticationException) {
            return response()->failure(
                statusCode: 401,
                errorMessage: 'Unauthenticated User.'
            );
        }

        if ($e instanceof UnauthorizedException) {
            return response()->failure(
                statusCode: 403,
                errorMessage: 'Forbidden! does not have authority over this resource.'
            );
        }

        return parent::render($request, $e);
    }
}
