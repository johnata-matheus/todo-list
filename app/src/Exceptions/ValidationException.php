<?php 

namespace App\Exceptions;

class ValidationException extends \Exception
{
    public function __construct(string $message = 'Erro de validação.', int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
