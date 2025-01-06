<?php 

namespace App\Http\Validators;

use App\Exceptions\ValidationException;

class TaskValidator
{
  public static function validateCreation(array $data): void
  {
    if (empty($data['title'])) {
      throw new ValidationException('O título da tarefa é obrigatório.', 400);
    }
    if (strlen($data['title']) > 255) {
      throw new ValidationException('O título da tarefa não pode exceder 255 caracteres.', 400);
    }
  }

  public static function validateUpdate(array $data): void
  {
    if (isset($data['title']) && empty($data['title'])) {
      throw new ValidationException('O título da tarefa é obrigatório.', 400);
    }

    if (isset($data['title']) && strlen($data['title']) > 255) {
      throw new ValidationException('O título da tarefa não pode exceder 255 caracteres.', 400);
    }
  }
}
