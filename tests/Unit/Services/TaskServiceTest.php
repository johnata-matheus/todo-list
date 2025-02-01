<?php

use App\Exceptions\TaskNotFoundException;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\TaskService;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    /** @var TaskRepositoryInterface&MockInterface */
    private TaskRepositoryInterface $repository;
    private TaskService $service;

    protected function setUp(): void
    {
        /** @var TaskRepositoryInterface&MockInterface */
        $this->repository = Mockery::mock(TaskRepositoryInterface::class);
        $this->service = new TaskService($this->repository);
    }

    /** @test */
    public function it_should_returns_all_tasks_success()
    {
        $mockResponse = [
            [
                'id' => 1,
                'title' => 'asdasd33',
                'description' => 'lorem222',
                'status' => 'pending',
                'created_at' => '2025-01-06 11:02:51',
                'updated_at' => '2025-01-18 18:56:29',
            ],
            [
                'id' => 2,
                'title' => 'testando',
                'description' => 'lorem222',
                'status' => 'pending',
                'created_at' => '2025-01-06 12:49:10',
                'updated_at' => null,
            ],
        ];

        $this->repository
          ->shouldReceive('findAll')
          ->once()
          ->andReturn($mockResponse);

        $result = $this->service->fetchAllTasks();

        $this->assertEquals($mockResponse, $result);
    }

    /** @test */
    public function throws_exception_if_no_tasks_found()
    {
        $this->repository
          ->shouldReceive('findAll')
          ->once()
          ->andReturn([]);

        $this->expectException(TaskNotFoundException::class);
        $this->expectExceptionMessage('Nenhuma tarefa encontrada.');

        $this->service->fetchAllTasks();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
