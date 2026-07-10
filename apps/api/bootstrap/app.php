<?php

use App\Support\ApiResponse;
use App\Support\ErrorResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (
            ModelNotFoundException $e,
            Request $request
        ) {
            if ($request->expectsJson()) {

                return ApiResponse::error(
                    message: 'Resource not found.',
                    status: 404
                );
            }
        });

        $exceptions->render(function (
            ValidationException $e,
            Request $request
        ) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    message: 'Validation failed.',
                    errors: $e->errors(),
                    status: 422
                );
            }
        });

        $exceptions->render(function (
            AuthenticationException $e,
            Request $request
        ) {

            if ($request->expectsJson()) {

                return ApiResponse::error(
                    message: 'Unauthenticated.',
                    status: 401
                );
            }
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return ErrorResponse::make(
                'Route not found.',
                [],
                404
            );
        });

        $exceptions->render(function (Throwable $e) {

            return ErrorResponse::make(
                app()->isProduction()
                    ? 'Something went wrong.'
                    : $e->getMessage(),
                [],
                500
            );
        });
    })->create();
