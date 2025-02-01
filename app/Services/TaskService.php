<?php

namespace App\Services;

use App\Exceptions\TaskNotFoundException;
use App\Models\TaskModel;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskService
{
    private TaskRepositoryInterface $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return TaskModel[]
     * @throws TaskNotFoundException
     */
    public function fetchAllTasks(): array
    {
        $tasks = $this->repository->findAll();

        if (!$tasks) {
            throw new TaskNotFoundException('Nenhuma tarefa encontrada.');
        }

        return $tasks;
    }

    /**
     * @param int $id
     * @return array<string, mixed>
     * @throws TaskNotFoundException
     */
    public function fetchTaskById(int $id): array
    {
        $task = $this->repository->findById($id);

        if (!$task) {
            throw new TaskNotFoundException();
        }

        return $task;
    }

    /**
     * @param array<string, mixed> $data
     * @return bool
     */
    public function createTask(array $data): bool
    {
        $task = new TaskModel(
            title: $data['title'],
            description: $data['description'],
            status: $data['status'] ?? 'pending',
        );

        return $this->repository->save($task);
    }

    /**
     * @param int $id 
     * @param array<string, mixed> $data
     * @return bool
     * @throws TaskNotFoundException
     */
    public function updateTask(int $id, array $data): bool
    {
        $task = $this->repository->findById($id);

        if (!$task) {
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

    /**
     * @param int $id
     * @return bool
     * @throws TaskNotFoundException
     */
    public function deleteTask(int $id): bool
    {
        $task = $this->repository->findById($id);

        if (!$task) {
            throw new TaskNotFoundException();
        }

        return $this->repository->delete($id);
    }
}
