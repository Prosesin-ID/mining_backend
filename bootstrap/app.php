<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\ValidateUserMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', 
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
        'validate.user' => ValidateUserMiddleware::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Force JSON response for API routes
        $exceptions->shouldRenderJsonWhen(function ($request, Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });
        
        // Custom rendering for API exceptions
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
                
                // Handle authentication exceptions
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sesi Anda telah berakhir. Silakan login kembali.',
                    ], 401);
                }
                
                // Handle authorization exceptions
                if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak memiliki akses untuk melakukan aksi ini.',
                    ], 403);
                }
                
                // Handle validation exceptions
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data yang Anda masukkan tidak valid.',
                        'errors' => $e->errors(),
                    ], 422);
                }
                
                // Handle model not found exceptions
                if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data tidak ditemukan.',
                    ], 404);
                }
                
                // Handle general exceptions
                return response()->json([
                    'success' => false,
                    'message' => config('app.debug') 
                        ? $e->getMessage() 
                        : 'Terjadi kesalahan pada server. Silakan coba lagi.',
                    'error' => config('app.debug') ? [
                        'exception' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                    ] : null,
                ], $status >= 100 && $status < 600 ? $status : 500);
            }
        });
    })->create();
