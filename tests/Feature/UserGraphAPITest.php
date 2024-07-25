<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserGraphAPITest extends TestCase
{
    use RefreshDatabase;

    public function test_user_login(): void
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $response = $this->post('/graphql/guest', [ 'query' => 'mutation {loginUser(email: "test@example.com", password: "password")}' ]);

        $this->assertAuthenticated('api');
    }

    public function test_get_user_details()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $loginUser = $this->post('/graphql/guest', [ 'query' => 'mutation {loginUser(email: "test@example.com", password: "password")}' ]);
        $response = $this->post('/graphql/auth', [ 'query' => 'query {userQuery{id name email tasks{id name status}}}' ]);

        $decodeContent = json_decode($response->getContent(), true);
        
        $this->assertTrue(!isset($decodeContent['errors']) && !empty($decodeContent['data']['userQuery']));
    }
}