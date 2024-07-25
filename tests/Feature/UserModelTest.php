<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_five_accounts(): void
    {
        $this->seed(UserSeeder::class);

        $this->assertDatabaseCount('users', 5);
    }

    public function test_create_user(): void
    {
        $assertTrue = false;

        $user = User::factory(1)->create();

        if ($user) $assertTrue = true;
        
        $this->assertTrue($assertTrue);
    }

    public function test_update_user(): void
    {
        $assertTrue = false;

        $user = User::factory(1)->create();

        if ($user) {
            $updateUser = User::find($user[0]->id);
            $updateUser->name = 'Test Update';

            if ($updateUser->save()) {
                $assertTrue = true;
            }
        }
        
        $this->assertTrue($assertTrue);
    }

    public function test_delete_user(): void
    {
        $assertTrue = false;

        $user = User::factory(1)->create();

        if ($user) {
            $deleteUser = User::find($user[0]->id);
            $assertTrue = $deleteUser->delete();
        }

        $this->assertTrue($assertTrue);
    }

    public function test_has_tasks(): void
    {
        $user = User::factory(1)->create();
        $task = Task::factory(1)->create(['user_id' => $user[0]->id]);

        $userHasTasks = User::select('id')->has('tasks')->where('id', $user[0]->id)->first();

        $this->assertNotEmpty($userHasTasks);
    }
}
