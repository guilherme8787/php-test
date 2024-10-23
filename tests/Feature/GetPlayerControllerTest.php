<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Player;
use Illuminate\Http\Response;

class GetPlayerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_player_successfully()
    {
        $user = User::factory()->create();
        $player = Player::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->getJson('/api/players/' . $player->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['data' => ['id' => $player->id]]);
    }

    public function test_get_not_found_a_player()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->getJson('/api/player/1');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
