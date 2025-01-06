<?php

namespace App\Http\Middlewares;

use App\Http\Response as HttpResponse;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Throwable;

class GlobalExceptionHandler
{
  public function __invoke(Request $request, Throwable $exception, bool $errorDetails): Response
  {
    $statusCode = $exception->getCode() ?: 500;

    error_log(sprintf(
      "[%s] %s: %s in %s on line %d",
      get_class($exception),
      $exception->getCode() ?: 500,
      $exception->getMessage(),
      $exception->getFile(),
      $exception->getLine()
    ));

    $errorMessage = $statusCode === 500
      ? 'Ocorreu um erro inesperado.' 
      : $exception->getMessage(); 

    $errorResponse = [
      'success' => false,
      'status'  => $statusCode,
      'error'   => $errorMessage,
      'path'    => (string) $request->getUri()->getPath(),
      'method'  => $request->getMethod(),
    ];

    return HttpResponse::json(new Response(), $errorResponse, $statusCode);
  }
}