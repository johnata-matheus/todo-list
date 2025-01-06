<?php

namespace App\Exceptions;

class TaskNotFoundException extends \Exception 
{
  public function __construct(string $message = 'Tarefa não encontrada.', int $code = 404)
  {
    parent::__construct($message, $code);
  }
}