<?php

/**
 * @var \Slim\App $app
 */

use App\Http\Controllers\TaskController;

$app->get('/tasks', [TaskController::class, 'getAllTasks']);
$app->get('/tasks/{id}', [TaskController::class, 'getTaskById']);
$app->post('/tasks', [TaskController::class, 'createTask']);
$app->put('/tasks/{id}', [TaskController::class, 'updateTask']);
$app->delete('/tasks/{id}', [TaskController::class, 'deleteTask']);