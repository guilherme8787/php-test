<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Player;
use Illuminate\Http\Response;

class GetAllPlayerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_players_successfully()
    {
        $user = User::factory()->create();
        $players = Player::factory()->count(3)->create();

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->getJson('/api/players');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3, 'data');
    }

    public function test_get_all_players_empty()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->getJson('/api/players');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(0, 'data');
    }
}
