<?php

namespace Tests\Feature;

use App\Console\Commands\PopulatePlayersCommand;
use App\Exceptions\TooManyRequestsException;
use App\Jobs\GetPlayersJob;
use App\Models\Player;
use App\Models\Team;
use App\Repositories\Player\PlayerRepositoryContract;
use App\Repositories\Team\TeamRepositoryContract;
use App\Services\BallDontLie\Contracts\BallDontLieServiceContract;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class PopulatePlayersCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var int
     */
    private const PER_PAGE = 100;

    public function setUp(): void
    {
        parent::setUp();
        Queue::fake();
    }

    private function preparedGreeWayMockData(): array
    {
        return [
            'data' => [
                [
                    'id' => 1,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'team' => [
                        'id' => 1,
                    ],
                ],
            ],
            'meta' => [
                'next_cursor' => null,
            ],
        ];
    }

    /** @test */
    public function green_way_of_populate_players_command()
    {
        $response = $this->preparedGreeWayMockData();

        $this->instance(
            BallDontLieServiceContract::class,
            Mockery::mock(BallDontLieServiceContract::class,
                function (MockInterface $mock) use ($response) {
                    $mock->shouldReceive('getPlayers')
                        ->once()
                        ->andReturn([
                            $response
                        ]);
                }
            )
        );

        $this->instance(
            PlayerRepositoryContract::class,
            Mockery::mock(PlayerRepositoryContract::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('find')
                        ->with(1)
                        ->andReturn(
                            new Team()
                        );
                }
            )
        );

        $this->instance(
            TeamRepositoryContract::class,
            Mockery::mock(TeamRepositoryContract::class,
                function (MockInterface $mock) use ($response) {
                    $mock->shouldReceive('createPlayerFromApi')
                        ->andReturn(
                            new Player()
                        );
                }
            )
        );

        $this->artisan(PopulatePlayersCommand::class);
    }

    /** @test */
    public function test_queue_of_populate_players_command_api_limit_exception()
    {
        $response = $this->preparedGreeWayMockData();

        $this->instance(
            BallDontLieServiceContract::class,
            Mockery::mock(BallDontLieServiceContract::class,
                function (MockInterface $mock) use ($response) {
                    $mock->shouldReceive('getPlayers')
                        ->andThrow(new TooManyRequestsException());
                }
            )
        );

        $this->artisan(PopulatePlayersCommand::class);

        Queue::assertPushed(GetPlayersJob::class);
    }

    /** @test */
    public function red_way_of_populate_players_command()
    {
        Log::spy();

        $this->instance(
            BallDontLieServiceContract::class,
            Mockery::mock(BallDontLieServiceContract::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('getPlayers')
                        ->andThrow(new Exception());
                }
            )
        );

        Log::shouldReceive('error')
            ->once()
            ->withAnyArgs();

        $this->artisan(PopulatePlayersCommand::class);
    }
}
