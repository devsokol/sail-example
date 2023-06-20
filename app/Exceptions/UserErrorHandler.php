<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

class UserErrorHandler extends Exception
{
    public function handle(Exception $exception): JsonResponse
    {
        if ($exception instanceof QueryException) {
            return response()->json([
                'error' => 'An error occurred while processing the user request'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'error' => 'An unexpected error occurred'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
