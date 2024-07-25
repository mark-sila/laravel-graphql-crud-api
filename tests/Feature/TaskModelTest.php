<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\TaskSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_twenty_tasks(): void
    {
        $this->seed(UserSeeder::class);
        $this->seed(TaskSeeder::class);

        $this->assertDatabaseCount('tasks', 20);
    }

    public function test_create_task(): void
    {
        $assertTrue = false;

        $user = Task::factory(1)->create();

        if ($user) $assertTrue = true;
        
        $this->assertTrue($assertTrue);
    }

    public function test_update_task(): void
    {
        $assertTrue = false;

        $user = Task::factory(1)->create();

        if ($user) {
            $updateUser = Task::find($user[0]->id);
            $updateUser->name = 'Test Update';

            if ($updateUser->save()) {
                $assertTrue = true;
            }
        }
        
        $this->assertTrue($assertTrue);
    }

    public function test_delete_task(): void
    {
        $assertTrue = false;

        $user = Task::factory(1)->create();

        if ($user) {
            $deleteUser = Task::find($user[0]->id);
            $assertTrue = $deleteUser->delete();
        }

        $this->assertTrue($assertTrue);
    }

    public function test_has_associated_user(): void
    {
        $user = User::factory(1)->create();
        $task = Task::factory(1)->create(['user_id' => $user[0]->id]);

        $hasAssociatedUser = Task::select(['id', 'user_id'])->has('user')->where('id', $task[0]->id)->first();

        $this->assertNotNull($hasAssociatedUser);
    }
}
