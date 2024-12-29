<?php

/**
 * @var \Slim\App $app
 */

use App\Http\Controllers\TaskController;

$app->get('/todos', [TaskController::class, 'getAllTasks']);
$app->get('/todos/{id}', [TaskController::class, 'getTaskById']);
$app->post('/todos', [TaskController::class, 'createTask']);
$app->put('/todos/{id}', [TaskController::class, 'updateTask']);
$app->delete('/todos/{id}', [TaskController::class, 'deleteTask']);

