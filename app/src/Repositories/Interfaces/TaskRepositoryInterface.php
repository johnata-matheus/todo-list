<?php

namespace App\Repositories\Interfaces;

use App\Models\TaskModel;

interface TaskRepositoryInterface 
{
  public function findAll(): array;

  public function findById(int $id): array;

  public function save(TaskModel $task): bool;

  public function update(TaskModel $task): bool;

  public function delete(int $id): bool;
}