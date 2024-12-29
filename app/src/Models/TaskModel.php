<?php

namespace App\Models;

class TaskModel
{
  public function __construct(
    public readonly string $title,
    public readonly ?string $description = null,
    public readonly string $status = 'pending',
    public readonly ?int $id = null,
    public readonly ?string $created_at = null,
    public readonly ?string $updated_at = null,
  ) {}

  public function toArray(): array
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'status' => $this->status,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
