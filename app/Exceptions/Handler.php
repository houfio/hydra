<?php

namespace App\Exceptions;

use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        $rendered = parent::render($request, $e);
        $code = $rendered->getStatusCode();
        $message = $e->getMessage();
        $info = null;

        if ($e instanceof UnauthorizedException) {
            $code = 401;
        } else if ($e instanceof ValidationException) {
            $info = json_decode($e->getResponse()->content());
        }

        return response()->json([
            'success' => false,
            'error' => [
                'code' => $code,
                'message' => $message,
                'info' => $info
            ]
        ], $code);
    }
}
