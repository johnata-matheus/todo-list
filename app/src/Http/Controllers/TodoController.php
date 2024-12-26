<?php

namespace App\Http\Controllers;

use App\Http\Request as HttpRequest;
use App\Http\Response as JsonResponse;
use App\Services\TodoService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class TodoController {

  private TodoService $service;

  public function __construct(TodoService $service)
  {
    $this->service = $service;
  }

  public function getAllTodos(Request $request, Response $response): Response
  {
    try {
      $todos = $this->service->fetchAllTodos();
      
      return JsonResponse::json($response, [
        'success' => true,
        'data'    => $todos,
      ], 200);
      
    } catch (\Exception $e) {

      return JsonResponse::json($response, [
        'success' => false,
        'error'   => 'Erro ao buscar as tarefas: ' . $e->getMessage(),
      ], 500);
    }
  }

  public function getTodoById(Request $request, Response $response): Response
  {
    try {
      $id = (int) $request->getAttribute('id');

      $todo = $this->service->fetchTodoById($id);

      if(!$todo) {
        return JsonResponse::json($response, [
          'success' => false,
          'error'   =>  "Tarefa não encontrada.",
        ], 404);
      }

      return JsonResponse::json($response, [
        'success' => true,
        'data'    => $todo,
      ], 200);
      
    } catch (\Exception $e) {

      error_log($e->getMessage());

      return JsonResponse::json($response, [
        'success' => false,
        'error'   => 'Erro ao buscar as tarefa. Tente novamente.',
      ], 500);
    }
  }

  public function createTodo(Request $request, Response $response): Response
  {    
    try {
      $data = json_decode($request->getBody()->getContents(), true);

      $todo = $this->service->createTodo($data);

      if($todo) {
        return JsonResponse::json($response, [
          'success' => true,
          'message' => 'Tarefa criada com sucesso',
        ], 201);
      }
      
      return JsonResponse::json($response, [
        'success' => false,
        'error' => 'Falha ao criar tarefa',
      ], 400);
      
    } catch (\Exception $e) {

      return JsonResponse::json($response, [
        'success' => false,
        'error'   => 'Erro ao criar tarefa: ' . $e->getMessage(),
      ], 500);
    }
  }
}
