<?php

namespace App\Services;

use App\Exceptions\TaskServiceException;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Models\TaskModel;

class TaskService 
{
  private TaskRepositoryInterface $repository;

  public function __construct(TaskRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function fetchAllTasks(): array
  {
    try {
      return $this->repository->findAll();
    } catch (\Exception $e) {
      throw new TaskServiceException("Erro ao buscar as tarefas: " . $e->getMessage());
    }
  }

  public function fetchTaskById(int $id): array
  {
    try {
      return $this->repository->findById($id);
    } catch (\Exception $e) {
      throw new TaskServiceException("Erro ao buscar tarefa com ID: {$id} " . $e->getMessage());
    }
  }

  public function createTask(array $data): bool
  {
    try {
      $task = new TaskModel(
        title: $data['title'],
        description: $data['description'],
        status: $data['status'] ?? 'pending',
      );

      return $this->repository->save($task);
    } catch (\Exception $e) {
      throw new TaskServiceException("Erro ao criar a tarefa: " . $e->getMessage());
    }
  }

  public function updateTask(int $id, array $data): bool
  {
    try {
      $existingTask = $this->repository->findById($id);

      if(!$existingTask) {
        return false;
      }

      $updatedTask = new TaskModel(
        id: $id,
        title: $data['title'] ?? $existingTask['title'],
        description: $data['description'] ?? $existingTask['description'],
        status: $data['status'] ?? $existingTask['status'],
        created_at: $existingTask['created_at'],
        updated_at: date('Y-m-d H:i:s'),
      );

      return $this->repository->update($updatedTask);

    } catch (\Exception $e) {
      throw new TaskServiceException("Erro ao atualizar a tarefa com ID {$id} ". $e->getMessage());
    }
  }

  public function deleteTask(int $id): bool
  {
    try { 
      $existingTask = $this->repository->findById($id);
      
      if(!$existingTask) {
        return false;
      }

      return $this->repository->delete($id);
      
    } catch (\Exception $e) {
      throw new TaskServiceException("Erro ao deletar tarefa com ID {$id}" . $e->getMessage());
    }
  }
}