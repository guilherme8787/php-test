<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Response;

class CreatePlayerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array
     */
    private const PLAYER_DATA = [
        'first_name' => 'Guilherme',
        'last_name' => 'Mendes',
        'position' => 'G',
        'height' => '6-2',
        'weight' => 185,
        'jersey_number' => '30',
        'college' => 'Davidson',
        'country' => 'USA',
        'draft_year' => 2009,
        'draft_round' => 1,
        'draft_number' => 7,
    ];

    public function test_create_player_successfully()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $playerData = array_merge(self::PLAYER_DATA, ['team_id' => $team->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->postJson('/api/players', $playerData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => ['first_name' => 'Guilherme']]);
    }

    public function test_create_player_with_wrong_field_type()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $playerData = array_merge(self::PLAYER_DATA, ['team_id' => $team->id]);
        data_forget($playerData, 'first_name');

        $response = $this->actingAs($user, 'sanctum')
            ->withHeaders(['X-Authorization' => 'cheetos'])
            ->postJson('/api/players', $playerData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'errors' => [
                    'first_name' => [
                        'The first name field is required.',
                    ]
                ],
            ]);
    }
}
