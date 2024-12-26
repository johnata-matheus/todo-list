<?php

namespace App\Services;

use App\Models\TodoModel;
use App\Repositories\TodoRepository;

class TodoService 
{
  private TodoRepository $repository;

  public function __construct(TodoRepository $repository)
  {
    $this->repository = $repository;
  }

  public function fetchAllTodos(): array
  {
    try {
      return $this->repository->findAll();
    } catch (\Exception $e) {
      throw new \RuntimeException("Erro ao buscar as tarefas: " . $e->getMessage());
    }
  }

  public function fetchTodoById(int $id): array
  {
    return $this->repository->findById($id);
  }

  public function createTodo(array $data): bool
  {
    error_log('saveee: ' . print_r($data, true));

      $todo = new TodoModel(
        id: null,
        name: $data['name'],
        description: $data['description'],
        active: $data['active'],
      );
    
      return $this->repository->save($todo);
  
  }
}