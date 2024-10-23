<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Player;
use Illuminate\Http\Response;

class UpdatePlayerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_player_successfully()
    {
        $user = User::factory()->create();
        $player = Player::factory()->create();

        $updatedData = ['first_name' => 'Updated'];

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->putJson('/api/players/' . $player->id, $updatedData);

        $response->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJson([
                'message' => 'Player updated successfully',
            ]);
    }

    public function test_update_player_with_wrong_field_type()
    {
        $user = User::factory()->create();
        $player = Player::factory()->create();

        $updatedData = ['weight' => 'test'];

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->putJson('/api/players/' . $player->id, $updatedData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'errors' => [
                    'weight' => [
                        'The weight field must be an integer.',
                    ],
                ],
            ]);
    }
}
