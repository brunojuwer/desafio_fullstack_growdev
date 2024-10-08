<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\UnauthorizedException;
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
        $this->reportable(function (Throwable $e) {});

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'message' => 'Mentor with ID ' . $request->route()->mentor . ' not found.',
            ], 404);
        });

        $this->renderable(function (UnauthorizedException $e, $request) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        });
    }
}
