<?php

namespace App\Repositories\Interfaces;

use App\Models\TaskModel;

interface TaskRepositoryInterface
{
    /**
     * @return TaskModel[]
     */
    public function findAll(): array;

    /**
     * @return array<string, mixed>
     */
    public function findById(int $id): array;

    public function save(TaskModel $task): bool;

    public function update(TaskModel $task): bool;

    public function delete(int $id): bool;
}
