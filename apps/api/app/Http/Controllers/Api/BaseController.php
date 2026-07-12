<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

abstract class BaseController extends Controller
{
    protected function success(
        mixed $data = null,
        string $message = 'Success.',
        array $meta = [],
        int $status = 200
    ): JsonResponse {
        return ApiResponse::success(
            data: $data,
            message: $message,
            meta: $meta,
            status: $status,
        );
    }

    protected function error(
        string $message,
        array $errors = [],
        int $status = 400
    ): JsonResponse {
        return ApiResponse::error(
            message: $message,
            errors: $errors,
            status: $status,
        );
    }

    protected function created(
        mixed $data = null,
        string $message = 'Created successfully.'
    ): JsonResponse {
        return ApiResponse::created(
            data: $data,
            message: $message,
        );
    }

    protected function updated(
        mixed $data = null,
        string $message = 'Updated successfully.'
    ): JsonResponse {
        return ApiResponse::updated(
            data: $data,
            message: $message,
        );
    }

    protected function deleted(
        string $message = 'Deleted successfully.'
    ): JsonResponse {
        return ApiResponse::deleted(
            message: $message,
        );
    }

    protected function unauthorized(
        string $message = 'Unauthenticated.'
    ): JsonResponse {
        return ApiResponse::unauthorized($message);
    }

    protected function forbidden(
        string $message = 'Forbidden.'
    ): JsonResponse {
        return ApiResponse::forbidden($message);
    }

    protected function notFound(
        string $message = 'Resource not found.'
    ): JsonResponse {
        return ApiResponse::notFound($message);
    }

    protected function conflict(
        string $message = 'Resource already exists.'
    ): JsonResponse {
        return ApiResponse::conflict($message);
    }

    protected function validationError(
        array $errors,
        string $message = 'Validation failed.'
    ): JsonResponse {
        return ApiResponse::validationError(
            errors: $errors,
            message: $message,
        );
    }
}
