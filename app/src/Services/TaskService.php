<?php

namespace App\Services;

use App\Exceptions\TaskNotFoundException;
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
    $tasks = $this->repository->findAll();

    if(!$tasks) {
      throw new TaskNotFoundException('Nenhuma tarefa encontrada.');
    }

    return $tasks;
  }

  public function fetchTaskById(int $id): array
  {
    $task = $this->repository->findById($id);
    
    if(!$task) {
      throw new TaskNotFoundException();
    }

    return $task;
  }

  public function createTask(array $data): bool
  {
    $task = new TaskModel(
      title: $data['title'],
      description: $data['description'],
      status: $data['status'] ?? 'pending',
    );

    return $this->repository->save($task);
  }

  public function updateTask(int $id, array $data): bool
  {
    $task = $this->repository->findById($id);

    if(!$task) {
      throw new TaskNotFoundException();
    }

    $updatedTask = new TaskModel(
      id: $id,
      title: $data['title'] ?? $task['title'],
      description: $data['description'] ?? $task['description'],
      status: $data['status'] ?? $task['status'],
      created_at: $task['created_at'],
      updated_at: date('Y-m-d H:i:s'),
    );

    return $this->repository->update($updatedTask);
  }

  public function deleteTask(int $id): bool
  {
    $task = $this->repository->findById($id);

    if(!$task) {
      throw new TaskNotFoundException();
    }

    return $this->repository->delete($id);  
  }
}