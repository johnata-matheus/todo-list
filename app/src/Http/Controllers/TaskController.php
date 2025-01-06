<?php

namespace App\Http\Controllers;

use App\Http\Request as HttpRequest;
use App\Http\Response as HttpResponse;
use App\Http\Validators\TaskValidator;
use App\Services\TaskService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class TaskController {

  private TaskService $service;

  public function __construct(TaskService $service)
  {
    $this->service = $service;
  }

  public function getAllTasks(Request $request, Response $response): Response
  {
    $tasks = $this->service->fetchAllTasks();
      
    return HttpResponse::json($response, [
      'success' => true,
      'data'    => $tasks,
    ], 200);
  }

  public function getTaskById(Request $request, Response $response): Response
  {
    $id = (int) $request->getAttribute('id');
    $task = $this->service->fetchTaskById($id);

    return HttpResponse::json($response, [
      'success' => true,
      'data'    => $task,
    ], 200);
  }

  public function createTask(Request $request, Response $response): Response
  {    
    $data = HttpRequest::getBody($request);
    TaskValidator::validateCreation($data);
    
    $this->service->createTask($data);

    return HttpResponse::json($response, [
      'success' => true,
      'message' => 'Tarefa criada com sucesso.',
    ], 201);
  }

  public function updateTask(Request $request, Response $response): Response
  {
    $id = (int) $request->getAttribute('id');
    
    $data = HttpRequest::getBody($request);
    TaskValidator::validateUpdate($data);

    $this->service->updateTask($id, $data);

    return HttpResponse::json($response, [
      'success' => true,
      'message' => 'Tarefa atualizada com sucesso.',
    ], 200);
  }

  public function deleteTask(Request $request, Response $response): Response
  {
    $id = (int) $request->getAttribute('id');

    $this->service->deleteTask($id);

    return HttpResponse::json($response, [
      'success' => true,
      'error' => 'Tarefa deletada com sucesso.',
    ], 200);
  }

}
