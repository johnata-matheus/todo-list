<?php

namespace App\Repositories;

use App\Database\Database;
use App\Models\TaskModel;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use PDO;

class TaskRepository implements TaskRepositoryInterface
{
  protected string $table = 'tasks';
  protected PDO $db;

  public function __construct()
  {
    $this->db = Database::getConnection();
  }

  public function findAll(): array
  {
    $sql = "SELECT * FROM {$this->table}";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
  
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return array_map(fn($task) => (new TaskModel(...$task))->toArray(), $tasks);
  }
  
  public function findById(int $id): array
  {
    $sql = "SELECT * FROM {$this->table} WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    if($task) {
      return (new TaskModel(...$task))->toArray();
    }
    
    return [];
  }

  public function save(TaskModel $task): bool
  {
    $sql = "INSERT INTO {$this->table} (title, description, status) 
            VALUES (:title, :description, :status)";
            
    $stmt = $this->db->prepare($sql);    

    $stmt->bindValue(':title', $task->title);
    $stmt->bindValue(':description', $task->description);
    $stmt->bindValue(':status', $task->status);

    return $stmt->execute();
  }
  
  public function update(TaskModel $task): bool
  {
    $sql = "UPDATE {$this->table} 
            SET title = :title, description = :description, status = :status, updated_at = :updated_at
            WHERE id = :id";
            
    $stmt = $this->db->prepare($sql);

    $stmt->bindValue(':title', $task->title);
    $stmt->bindValue(':description', $task->description);
    $stmt->bindValue(':status', $task->status);
    $stmt->bindValue(':updated_at', $task->updated_at);
    $stmt->bindValue(':id', $task->id, PDO::PARAM_INT);

    return $stmt->execute();
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM {$this->table} 
            WHERE id = :id";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
  }

}