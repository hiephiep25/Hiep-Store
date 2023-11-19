<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    final protected function success(string | array $message = "")
    {
        return response()->json([
            'message' => empty($message) ? "Success!" : $message
        ]);
    }

    final protected function failed(string|array $message = '', string $status = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'message' => empty($message) ? "Failed!" : $message
        ], $status);
    }
}
