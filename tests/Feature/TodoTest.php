<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_todo()
    {
        $data = [
            'title' => 'Todo title',
            'description' => 'Todo description',
        ];

        $response = $this->post('/api/todos', $data);

        $this->assertDatabaseHas('todos', $response->json());
        $response->assertStatus(201)
            ->assertJsonStructure(array_keys($data));
    }

    public function test_it_get_all_the_todos()
    {
        $todos = Todo::factory(10)->create();

        $response = $this->get('/api/todos');

        $this->assertDatabaseCount('todos', $todos->count());
        $response->assertStatus(200)
            ->assertJsonCount($todos->count())
            ->assertJsonStructure([
                '*' => array_keys($todos->first()->toArray()),
            ]);
    }

    public function test_it_can_show_a_todo()
    {
        $todo = Todo::factory()->create();

        $response = $this->get("/api/todos/{$todo->id}");

        $this->assertDatabaseHas('todos', $response->json());
        $response->assertStatus(200)
            ->assertJsonStructure(array_keys($todo->toArray()));
    }

    public function test_it_can_update_a_todo()
    {
        $todo = Todo::factory()->create();

        $dataToBeUpdated = [
            'is_done' => true,
            'title' => 'updated title',
            'description' => 'updated description',
        ];
        $response = $this->put("/api/todos/{$todo->id}", $dataToBeUpdated);

        $this->assertDatabaseHas('todos', $response->json());
        $response->assertStatus(200)
            ->assertJsonFragment($dataToBeUpdated);
    }

    public function test_it_can_delete_a_todo()
    {
        $todo = Todo::factory()->create();

        $response = $this->delete("/api/todos/{$todo->id}");

        $this->assertDatabaseEmpty('todos');
        $response->assertStatus(204)
            ->assertNoContent();
    }

    public function test_it_can_throw_an_error_if_todo_is_not_found_while_update_delete_and_show()
    {
        $headers = [
            'Accept' => 'application/json',
        ];
        $showResponse = $this->get("/api/todos/1", $headers);
        $updateResponse = $this->put("/api/todos/1", [], $headers);
        $deleteResponse = $this->delete("/api/todos/1", [], $headers);

        $message = [
            'message' => 'Resource not found',
        ];
        $showResponse->assertStatus(404)
            ->assertJson($message);
        $updateResponse->assertStatus(404)
            ->assertJson($message);
        $deleteResponse->assertStatus(404)
            ->assertJson($message);
    }
}
