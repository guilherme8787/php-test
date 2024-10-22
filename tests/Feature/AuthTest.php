<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker as Faker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use Faker;
    use RefreshDatabase;

    /**
     * Returns prepared user data
     */
    private function prepareUserData(): array
    {
        return [
            'login' => 'test',
            'password' => '12345',
        ];
    }

    /**
     * Creates a user
     */
    private function createUser(): User
    {
        return User::factory()->create([
            'login' => 'test',
            'password' => bcrypt(12345)
        ]);
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $this->createUser();

        $response = $this->postJson('api/login', $this->prepareUserData());

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSeeText('token');
    }

    public function test_user_can_login_worng_credentials()
    {
        $response = $this->postJson('api/login', [
            'login' => $this->faker->userName,
            'password' => bcrypt($this->faker->password)
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'message' => 'Invalid credentials'
        ]);
    }
}
