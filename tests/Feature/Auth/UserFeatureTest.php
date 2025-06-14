<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_successfully()
    {
        $response = $this->postJson('/api/users/register', [
            'name'                  => 'Test User',
            'email'                 => 'testuser@gmail.com',
            'password'              => 'Password@123',
            'password_confirmation' => 'Password@123',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'response_code',
                     'response_message',
                     'response_data' => ['id', 'name', 'email']
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@gmail.com',
        ]);
    }

    public function test_user_can_not_register_with_wrong_input()
    {
        $response = $this->postJson('/api/users/register', [
            'name'                  => 'Test User',
            'email'                 => 'badinput@gmail.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'message',
                     'errors'
                 ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'badinput@gmail.com',
        ]);
    }

    public function test_user_can_login_and_receive_token()
    {
        $user = User::factory()->create([
            'email'    => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/users/login', [
            'email'    => 'user@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'response_code',
                     'response_message',
                     'response_data' => ['id', 'name', 'email', 'token']
                 ]);
    }

    public function test_user_can_not_login_with_wrong_data()
    {
        $user = User::factory()->create([
            'email'    => 'testlogin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/users/login', [
            'email'    => 'testlogin@gmail.com',
            'password' => 'wrongPassword',
        ]);

        $response->assertStatus(401)
                 ->assertJsonStructure([
                     'response_code',
                     'response_message',
                     'response_data',
                 ]);
    }

}
