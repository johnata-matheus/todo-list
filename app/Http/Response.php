<?php

namespace App\Http;

use Slim\Psr7\Response as Psr7Response;

class Response
{
    /**
     * @param Psr7Response $response 
     * @param array<string, mixed> $data
     * @param int $status 
     * @return Psr7Response
     */
    public static function json(Psr7Response $response, array $data = [], int $status = 200): Psr7Response
    {
        $payload = json_encode($data) ?: '{}';
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($status);
    }
}
