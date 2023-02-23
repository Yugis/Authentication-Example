<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function (
            array|Model|Collection $data = [],
            string $message = 'success',
            int $statusCode = 200,
            string|array $errorMessage = null
        ) {
            return Response::json([
                'statusCode' => $statusCode,
                'message' => $message,
                'error' => 0,
                'errorMessage' => $errorMessage,
                'data' => $data,
            ]);
        });

        Response::macro('failure', function (
            array $data = [],
            string $message = null,
            int $statusCode = 500,
            string|array $errorMessage = 'Generic Error'
        ) {
            return Response::json([
                'statusCode' => $statusCode,
                'message' => $message,
                'error' => 1,
                'errorMessage' => $errorMessage,
                'data' => $data,
            ]);
        });

        Response::macro('notFound', function (
            array $data = [],
            string $message = null,
            int $statusCode = 404,
            string $errorMessage = 'No data found.'
        ) {
            return Response::json([
                'statusCode' => $statusCode,
                'message' => $message,
                'error' => 1,
                'errorMessage' => $errorMessage,
                'data' => $data,
            ]);
        });
    }
}
