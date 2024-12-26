<?php

namespace App\Models;

class TodoModel
{
  public function __construct(
    public readonly ?int $id = null,
    public readonly string $name,
    public readonly string $description,
    public readonly bool $active = true,
  ) {}

  public function toArray(): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'active' => $this->active,
    ];
  }
}
