<?php

use App\Http\Controllers\TodoController;

$app->get('/todos', [TodoController::class, 'getAllTodos']);
$app->get('/todos/{id}', [TodoController::class, 'getTodoById']);
$app->post('/todos', [TodoController::class, 'createTodo']);