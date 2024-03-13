<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param  Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse
    {

        // 404 page when a model is not found
        // if ($e instanceof ModelNotFoundException) {
        //     return response()->json(['message' => __('errors.404')], Response::HTTP_NOT_FOUND);
        // }

        // if ($e instanceof HttpException) {
        //     // Custom error 500 view
        //     return response()->json(['message' => __('errors.500')], Response::HTTP_INTERNAL_SERVER_ERROR);
        // }

        return parent::render($request, $e);
    }
}
