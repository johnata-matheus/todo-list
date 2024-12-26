<?php

namespace App\Repositories;

use App\Config\Database;
use App\Models\TodoModel;
use PDO;

class TodoRepository
{
  protected string $table = 'todos';
  protected PDO $db;

  public function __construct()
  {
    $this->db = Database::getConnection();
  }

  public function findAll(): array
  {
    try {
      $sql = "SELECT * FROM {$this->table}";
      $stmt = $this->db->prepare($sql);
      $stmt->execute();

      $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return array_map(fn($todo) => (new TodoModel(...$todo))->toArray(), $todos);
    } catch (\PDOException $e) {
      throw new \Exception("Erro ao buscar tdos os registros: " . $e->getMessage());
    }
  }
  
  public function findById(int $id): array
  {
    try {
      $sql = "SELECT * FROM {$this->table} WHERE id = :id";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
  
      $todo = $stmt->fetch(PDO::FETCH_ASSOC);

      if($todo) {
        return (new TodoModel(...$todo))->toArray();
      }
      
      return [];
    } catch (\PDOException $e) {
      throw new \Exception("Erro ao buscar o registro pelo ID: " . $e->getMessage());
    }
  }

  public function save(TodoModel $todo): bool
  {
    try {
      $sql = "INSERT INTO {$this->table} (name, description, active) VALUES (:name, :description, :active)";
      $stmt = $this->db->prepare($sql);

      $stmt->bindValue(':name', $todo->name);
      $stmt->bindValue(':description', $todo->description);
      $stmt->bindValue(':active', $todo->active, PDO::PARAM_INT);

      return $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception("Erro ao salvar o registro: " . $e->getMessage());
    }
  }

}