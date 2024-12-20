<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Validation\ValidationException;


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

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->guest('/admin/login');
        }
        if ($request->is('company') || $request->is('company/*')) {
            return redirect()->guest('/company/login');
        }
        if ($request->is('vendor') || $request->is('vendor/*')) {
            return redirect()->guest('/vendor/login');
        }

        // return redirect()->guest(route('login'));
        
    }

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'errors' => $exception->errors(),
                ], 422);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            return response()->json([
                'error' => $exception->getMessage()
            ], method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);
        }

        return parent::render($request, $exception);
    }
}
