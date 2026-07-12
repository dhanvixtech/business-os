<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(
        mixed $data = null,
        string $message = 'Success.',
        array $meta = [],
        int $status = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => (object) $meta,
            'errors' => [],
        ], $status);
    }

    public static function error(
        string $message,
        array $errors = [],
        int $status = 400
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    public static function created(
        mixed $data = null,
        string $message = 'Created successfully.'
    ): JsonResponse {
        return self::success(
            data: $data,
            message: $message,
            status: 201,
        );
    }

    public static function updated(
        mixed $data = null,
        string $message = 'Updated successfully.'
    ): JsonResponse {
        return self::success(
            data: $data,
            message: $message,
        );
    }

    public static function deleted(
        string $message = 'Deleted successfully.'
    ): JsonResponse {
        return self::success(
            message: $message,
        );
    }

    public static function unauthorized(
        string $message = 'Unauthenticated.'
    ): JsonResponse {
        return self::error(
            message: $message,
            status: 401,
        );
    }

    public static function forbidden(
        string $message = 'Forbidden.'
    ): JsonResponse {
        return self::error(
            message: $message,
            status: 403,
        );
    }

    public static function notFound(
        string $message = 'Resource not found.'
    ): JsonResponse {
        return self::error(
            message: $message,
            status: 404,
        );
    }

    public static function conflict(
        string $message = 'Resource already exists.'
    ): JsonResponse {
        return self::error(
            message: $message,
            status: 409,
        );
    }

    public static function validationError(
        array $errors,
        string $message = 'Validation failed.'
    ): JsonResponse {
        return self::error(
            message: $message,
            errors: $errors,
            status: 422,
        );
    }
}
