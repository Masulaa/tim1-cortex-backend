<?php

namespace Tests\Feature;

use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Faker\Factory as Faker;

class AuthTest extends TestCase
{
    public function test_user_can_register()
    {
        $faker = Faker::create();

        $response = $this->postJson('/api/register', [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email'],
                'token'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com'
        ]);
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'testuser@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email'],
                'token'
            ]);
    }

    /**
     * Test invalid login.
     *
     * @return void
     */
    public function test_user_cannot_login_with_invalid_credentials()
    {

        $response = $this->postJson('/api/login', [
            'email' => 'lukamasulovic2@gmail.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'The provided credentials are incorrect.'
            ]);
    }
}
