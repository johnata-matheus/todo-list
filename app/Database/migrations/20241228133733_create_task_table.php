<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTaskTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('tasks');
        $table->addColumn('title', 'string', ['limit' => 255])
              ->addColumn('description', 'text', ['null' => true])
              ->addColumn('status', 'enum', ['values' => ['pending', 'completed', 'in_progress'], 'default' => 'pending'])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['null' => true, 'default' => null])
        ->create();
    }
}
