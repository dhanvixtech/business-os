<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ErrorResponse
{
    public static function make(
        string $message,
        array $errors = [],
        int $status = 400
    ): JsonResponse {

        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors,
            'meta' => [],
        ], $status);
    }
}
