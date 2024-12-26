<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load(); 

$containerBuilder = new ContainerBuilder();

$container = $containerBuilder->build();
AppFactory::setContainer($container);

$app = AppFactory::create();

require __DIR__ . '/../app/src/Http/routes/routes.php';

$app->run();
