<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskGraphApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $loginUser = $this->post('/graphql/guest', [ 'query' => 'mutation {loginUser(email: "test@example.com", password: "password")}' ]);
        $response = $this->post('/graphql/auth', [ 'query' => "mutation {createTask(user_id: $user->id, name: \"Test Task\", status: \"pending\"){id name status}}" ]);

        $decodeContent = json_decode($response->getContent(), true);

        $this->assertTrue(!isset($decodeContent['errors']) && !empty($decodeContent['data']['createTask']));
    }

    public function test_update_task()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);
        $task = Task::factory()->create(['name' => 'Test Task', 'status' => 'pending']);

        $loginUser = $this->post('/graphql/guest', [ 'query' => 'mutation {loginUser(email: "test@example.com", password: "password")}' ]);
        $response = $this->post('/graphql/auth', [ 'query' => "mutation {updateTask(id: $task->id, user_id: $user->id, name: \"Test Task Updated\", status: \"done\"){id name status}}" ]);

        $decodeContent = json_decode($response->getContent(), true);

        $this->assertTrue(!isset($decodeContent['errors']) && !empty($decodeContent['data']['updateTask']));
    }

    public function test_delete_task()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);
        $task = Task::factory()->create(['name' => 'Test Task', 'status' => 'pending']);

        $loginUser = $this->post('/graphql/guest', [ 'query' => 'mutation {loginUser(email: "test@example.com", password: "password")}' ]);
        $response = $this->post('/graphql/auth', [ 'query' => "mutation {deleteTask(id: $task->id)}" ]);

        $decodeContent = json_decode($response->getContent(), true);

        $this->assertTrue(!isset($decodeContent['errors']) && !empty($decodeContent['data']['deleteTask']));
    }
}
