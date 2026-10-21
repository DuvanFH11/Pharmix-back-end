<?php

use App\Exceptions\DuplicateCodeException;
use App\Exceptions\ExpiredCodeException;
use App\Exceptions\InvalidCodeException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Nette\Schema\ValidationException;
use PHPUnit\Util\ThrowableToStringMapper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        function handleResponseError($success, $message, $state, $exception, $error_code = null) {
            return response()->json([
                'success'    => $success,
                'message'    => $message,
                'exception'  => $exception,
                'error_code' => $error_code
            ], $state);
        }
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return match (true) {
                    
                    $e instanceof QueryException => 
                        handleResponseError(false, 'Lo sentimos, algo salió mal al procesar la solicitud', 500, class_basename($e),'DATABASE_ERROR'),
                    
                    $e instanceof NotFoundHttpException => 
                        handleResponseError(false, 'El recurso solicitado no existe', 404, class_basename($e), 'NOT_FOUND'),
                    
                    $e instanceof ValidationException => 
                        handleResponseError(false, 'Los datos proporcionados no son válidos', 422, class_basename($e), 'VALIDATION_ERROR'),
                    
                    $e instanceof InvalidCodeException => 
                        handleResponseError(false, 'El código ingresado es inválido', 422, class_basename($e), 'INVALID_CODE'),
                    
                    $e instanceof ExpiredCodeException =>
                        handleResponseError(false, 'El código ha expirado, solicite otro por favor', 422, class_basename($e), 'EXPIRED_CODE'),
                    
                    $e instanceof DuplicateCodeException => 
                        handleResponseError(false, 'Ya existe un código activo actualmente, ingreselo por favor', 422, class_basename($e), 'DUPLICATE_CODE'),
                    default => 
                        handleResponseError(false, 'El sistema no está disponible temporalmente, inténtalo más tarde', 500, class_basename($e),'SERVER_ERROR')
                };
            }
        });
    })->create();
