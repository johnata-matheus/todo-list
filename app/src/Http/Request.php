<?php

namespace App\Http;

use Slim\Psr7\Request as RequestSlim;

class Request 
{
  public static function getBody(RequestSlim $request): array
  {
    $data = json_decode($request->getBody()->getContents(), true);
    return $data;
  }
}