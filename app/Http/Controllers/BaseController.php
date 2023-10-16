<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function sendResponse($result, $message, $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $result,
        ], $code);
    }

    public function sendError($error, $code = 404): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $error,
        ], $code);
    }
}
