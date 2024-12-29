<?php

require __DIR__ . '/../../../vendor/autoload.php';

use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load(); 

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
  TaskRepositoryInterface::class => Di\autowire(TaskRepository::class),
]);

$container = $containerBuilder->build();
AppFactory::setContainer($container);

// criação do Slim
$app = AppFactory::create();

require __DIR__ . '/../Http/routes/routes.php';

$app->run();