<?php

namespace App\Http;

use Psr\Http\Message\ResponseInterface;

class Response {
  public static function json(ResponseInterface $response, array $data = [], int $status = 200): ResponseInterface
  {
    $payload = json_encode($data);
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json')
                    ->withStatus($status);
  }
}