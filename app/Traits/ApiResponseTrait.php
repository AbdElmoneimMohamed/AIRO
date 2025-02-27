<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Send a success response.
     *
     * @param  string|array  $message
     * @param  array  $data
     * @param  int  $statusCode
     */
    protected function sendSuccessResponse($message = 'Success', $data = [], $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Send an error response.
     *
     * @param  string|array  $message
     * @param  int  $statusCode
     */
    protected function sendErrorResponse($message = 'Error', $statusCode = 400): JsonResponse
    {
        $response = [
            'error' => true,
            'success' => false,
            'message' => $message,
        ];

        return response()->json($response, $statusCode);
    }
}
