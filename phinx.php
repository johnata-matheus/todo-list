<?php 

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
  'paths' => [
      'migrations' => 'app/Database/migrations',
      'seeds' => 'app/Database/seeds',
  ],
  'environments' => [
      'default_migration_table' => 'phinxlog',
      'default_environment' => 'development',
      'development' => [
          'adapter' => 'mysql',
          'host' => $_ENV['DB_HOST'], 
          'name' => $_ENV['DB_NAME'],
          'user' => $_ENV['DB_USER'],
          'pass' => $_ENV['DB_PASSWORD'],
          'port' => $_ENV['DB_PORT'],
          'charset' => 'utf8',
      ],
  ],
];