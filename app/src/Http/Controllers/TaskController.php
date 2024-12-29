<?php

namespace App\Http\Controllers;

use App\Http\Request as HttpRequest;
use App\Http\Response as HttpResponse;
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
    try {
      $tasks = $this->service->fetchAllTasks();
      
      return HttpResponse::json($response, [
        'success' => true,
        'data'    => $tasks,
      ], 200);
      
    } catch (\Exception $e) {
      error_log($e->getMessage());

      return HttpResponse::json($response, [
        'success' => false,
        'error'   => 'Erro ao buscar tarefas. Tente novamente.',
      ], 500);
    }
  }

  public function getTaskById(Request $request, Response $response): Response
  {
    try {
      $id = (int) $request->getAttribute('id');

      $task = $this->service->fetchTaskById($id);

      if(!$task) {
        return HttpResponse::json($response, [
          'success' => false,
          'error'   =>  "Tarefa não encontrada.",
        ], 404);
      }

      return HttpResponse::json($response, [
        'success' => true,
        'data'    => $task,
      ], 200);
      
    } catch (\Exception $e) {
      error_log($e->getMessage());

      return HttpResponse::json($response, [
        'success' => false,
        'error'   => 'Erro ao buscar tarefas. Tente novamente.',
      ], 500);
    }
  }

  public function createTask(Request $request, Response $response): Response
  {    
    try {
      $data = HttpRequest::getBody($request);

      $task = $this->service->createTask($data);

      if($task) {
        return HttpResponse::json($response, [
          'success' => true,
          'message' => 'Tarefa criada com sucesso.',
        ], 201);
      }
      
      return HttpResponse::json($response, [
        'success' => false,
        'error' => 'Falha ao criar tarefa.',
      ], 400);
      
    } catch (\Exception $e) {
      error_log($e->getMessage());

      return HttpResponse::json($response, [
        'success' => false,
        'error'   => 'Erro ao criar tarefa. Tente novamente.',
      ], 500);
    }
  }

  public function updateTask(Request $request, Response $response): Response
  {
    try {
      $id = (int) $request->getAttribute('id');

      $data = HttpRequest::getBody($request);

      $updated = $this->service->updateTask($id, $data);

      if (!$updated) {
        return HttpResponse::json($response, [
          'success' => false,
          'error' => 'Falha ao atualizar tarefa.',
        ], 404);
      }

      return HttpResponse::json($response, [
        'success' => true,
        'message' => 'Tarefa atualizada com sucesso.',
      ], 200);

    } catch (\Exception $e) {
      error_log($e->getMessage());

      return HttpResponse::json($response, [
        'success' => false,
        'error' => 'Erro ao atualizar tarefa. Tente novamente.',
      ], 500);
    }
  }

  public function deleteTask(Request $request, Response $response): Response
  {
    try {
      $id = (int) $request->getAttribute('id');

      $task = $this->service->deleteTask($id);

      if (!$task) {
        return HttpResponse::json($response, [
          'success' => false,
          'error' => 'Falha ao deletar tarefa.',
        ], 404);
      }

      return HttpResponse::json($response, [
        'success' => true,
        'error' => 'Tarefa deletada com sucesso.',
      ], 200);

    } catch (\Exception $e) {
      error_log($e->getMessage());

      return HttpResponse::json($response, [
        'success' => false,
        'error' => 'Erro ao editar tarefa. Tente novamente.',
      ], 500);
    }
  }

}
