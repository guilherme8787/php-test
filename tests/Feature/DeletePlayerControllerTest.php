<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Response;

class DeletePlayerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_player_successfully()
    {
        $user = User::factory()->create();
        $player = Player::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->deleteJson('/api/players/' . $player->id);

        $response->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJson([
                'message' => 'Player deleted successfully',
            ]);
        $this->assertDatabaseMissing('players', ['id' => $player->id]);
    }

    public function test_delete_player_not_found()
    {
        $user = User::factory()->create();
        $player = Player::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->deleteJson('/api/players/' . $player->id);

        $response->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJson([
                'message' => 'Player deleted successfully',
            ]);
        $this->assertDatabaseMissing('players', ['id' => $player->id]);
    }
}
