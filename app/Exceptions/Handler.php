<?php

namespace App\Exceptions;

use App\Http\Resources\ErrorResource;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): JsonResponse
    {
//        if ($e instanceof HttpException) {
//            return response()->json(new ErrorResource($e->getErrCode(), $e->getMessage()), $e->getStatusCode());
//        }
        return parent::render($request, $e);
//        return response()->json(new ErrorResource('API_ERROR', 'There is something wrong with the server'), 200);
    }
}
