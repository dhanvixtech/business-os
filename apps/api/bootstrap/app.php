<?php

use App\Support\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'permission' => PermissionMiddleware::class,
            'role' => RoleMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (
            UnauthorizedException $e,
            Request $request
        ) {

            return ApiResponse::error(
                message: 'You do not have permission to perform this action.',
                status: 403,
            );
        });

        $exceptions->render(function (
            AuthorizationException $e,
            Request $request
        ) {

            return ApiResponse::error(
                message: 'You are not authorized to perform this action.',
                status: 403,
            );
        });

        $exceptions->render(function (
            AccessDeniedHttpException $e,
            Request $request
        ) {

            return ApiResponse::error(
                message: 'You are not authorized to perform this action.',
                status: 403,
            );
        });

        $exceptions->render(function (
            ModelNotFoundException $e,
            Request $request
        ) {
            if ($request->expectsJson() || $request->is('api/*')) {

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

            if ($request->expectsJson() || $request->is('api/*')) {

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

            if ($request->expectsJson() || $request->is('api/*')) {

                return ApiResponse::error(
                    message: 'Unauthenticated.',
                    status: 401
                );
            }
        });

        $exceptions->render(function (
            NotFoundHttpException $e,
            Request $request
        ) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return ApiResponse::error(
                    message: 'Route not found.',
                    status: 404
                );
            }
        });

        $exceptions->render(function (
            Throwable $e,
            Request $request
        ) {

            if ($request->expectsJson() || $request->is('api/*')) {
                return ApiResponse::error(
                    message: app()->isProduction()
                        ? 'Something went wrong.'
                        : $e->getMessage(),
                    status: 500
                );
            }
        });
    })->create();
