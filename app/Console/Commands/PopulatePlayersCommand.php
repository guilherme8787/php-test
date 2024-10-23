<?php

namespace App\Console\Commands;

use App\Exceptions\TooManyRequestsException;
use App\Jobs\GetPlayersJob;
use App\Models\Team;
use App\Repositories\Player\PlayerRepositoryContract;
use App\Repositories\Team\TeamRepository;
use App\Repositories\Team\TeamRepositoryContract;
use App\Services\BallDontLie\BallDontLieService;
use App\Services\BallDontLie\Contracts\BallDontLieServiceContract;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PopulatePlayersCommand extends Command
{
    /**
     * @var int
     */
    private const INITIAL_VALUE = 0;

    /**
     * @var int
     */
    private const THIRTY_SECONDS = 30;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-players-command {perPage?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recupera todos os jogadores da API BallDontLie';

    /**
     * Execute the console command.
     */
    public function handle(
        BallDontLieServiceContract $ballDontLieService,
        PlayerRepositoryContract $playerRepository,
        TeamRepositoryContract $teamRepository
    ) {
        $nextCursor = $this->argument('perPage') ?? self::INITIAL_VALUE;
        $players = [];

        do {
            try {
                $response = $ballDontLieService->getPlayers($nextCursor);
                $players = data_get($response, 'data');

                Log::info('Start import', [
                    'class' => self::class,
                    'code' => 'command_populate_players_info',
                    'context' => data_get($response, 'meta')
                ]);

                if (!$players) {
                    $this->info('No players found');

                    return;
                }

                foreach ($players as $player) {
                    $teamId = data_get($player, 'team.id');

                    if (!$teamId) {
                        Log::error('Player with no team', [
                            'class' => self::class,
                            'code' => 'command_populate_players_error',
                        ]);

                        continue;
                    }

                    $teamFromDb = $teamRepository->find($teamId);

                    if (!$teamFromDb) {
                        $teamFromApi = $ballDontLieService->getTeam($teamId);

                        if (!$teamFromApi) {
                            $this->error('Team not found');

                            Log::error('Team not found continue to next team', [
                                'class' => self::class,
                                'code' => 'command_populate_players_error',
                                'context' => $player
                            ]);

                            continue;
                        }

                        $teamRepository->createTeamFromApi(
                            data_get($teamFromApi, 'data')
                        );
                    }

                    $playerRepository->createPlayerFromApi($player);

                    $firstName = data_get($player, 'first_name');
                    $lastName = data_get($player, 'last_name');

                    $this->info('Player created: ' . $firstName . ' ' . $lastName);

                    Log::info('Player created: ' . $firstName . ' ' . $lastName, [
                        'class' => self::class,
                        'code' => 'command_populate_players_success',
                    ]);
                }
            } catch (TooManyRequestsException $e) {
                $this->info('The service returns in 30 seconds');
                $this->info('Please execute $ php artisan queue:work');
                $this->info('See all players created in the log or in the database');

                dispatch(new GetPlayersJob($nextCursor))->delay(now()->addSeconds(
                    self::THIRTY_SECONDS
                ));

                return;

            } catch (Exception $e) {
                $this->error($e->getMessage());

                Log::error($e->getMessage(), [
                    'class' => self::class,
                    'code' => 'command_populate_players_error',
                ]);

                return;
            }

            $nextCursor = data_get($response, 'meta.next_cursor', null);

        } while ($nextCursor);

        Log::info('End import', [
            'class' => self::class,
            'code' => 'command_populate_players_info',
        ]);
    }
}
