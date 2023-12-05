<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_current_task(): void
    {
        $task = Task::factory()->create();
        $response = $this->get('/api/tasks');
        $response->assertOk();

        $response->assertSeeText($task->title);
        $response->assertSeeText($task->description);
        $response->assertSeeText($task->status);
        $response->assertSeeText($task->currentstatus);
    }

    public function test_create_new_task(): void
    {
        $this->withoutExceptionHandling();

        $data = [
                'title' => 'Test Task',
                'description' => 'Task 1',
                'status' => 2,
            ];

        $response = $this->post('/tasks', $data);

        $response->assertOk();
        $this->assertDatabaseCount('tasks', 1);

        $task = Task::first();
        $this->assertEquals($data['title'], $task->title);
        $this->assertEquals($data['description'], $task->description);
        $this->assertEquals($data['status'], $task->status);

    }

    public function test_failed_create_new_task_without_title(): void
    {
        $this->withoutExceptionHandling();

        $data = [
                'description' => 'Task 1',
                'status' => 2,
            ];

        $response = $this->post('/tasks', $data);
        $this->assertDatabaseCount('tasks', 0);
    }


    public function test_existing_task_can_be_retrieved(): void
    {
        $this->withoutExceptionHandling();

        $task = Task::factory()->create();

        $response = $this->get('/tasks/' . $task->id);

        $response->assertSeeText($task->title);
        $response->assertSeeText($task->description);
        $response->assertSeeText($task->status);
        $response->assertSeeText($task->currentstatus);

    }

    public function test_update_existing_task(): void
    {
        $this->withoutExceptionHandling();

        $task = Task::factory()->create();

        $data = [
            'title' => 'Update Task',
            'description' => 'Update Task 1',
            'status' => 0,
        ];

        $response = $this->patch('/tasks/' . $task->id, $data);
        $response->assertOk();

        $updated = Task::first();
        $this->assertEquals($data['title'], $updated->title);
        $this->assertEquals($data['description'], $updated->description);
        $this->assertEquals($data['status'], $updated->status);
        $this->assertEquals($task->id, $updated->id);

    }

    public function test_delete_existing_task(): void
    {
        $this->withoutExceptionHandling();

        $task = Task::factory()->create();
        $response = $this->delete('/tasks/'. $task->id);
        $response->assertOk();

        $this->assertDatabaseCount('tasks', 0);
    }
    
}
