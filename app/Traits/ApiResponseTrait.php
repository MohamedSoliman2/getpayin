<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($data = null, string $message = 'Success', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    protected function errorResponse(string $message = 'Error', $errors = null, int $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }
     protected function successMessageResponse(string $message = 'success', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            
        ], $status);
    }

    protected function validationError($errors, string $message = 'Validation error')
    {
        return $this->errorResponse($message, $errors, 422);
    }
}
