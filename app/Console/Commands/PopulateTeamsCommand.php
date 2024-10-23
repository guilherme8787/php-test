<?php

namespace App\Console\Commands;

use App\Exceptions\TooManyRequestsException;
use App\Jobs\GetPlayersJob;
use App\Repositories\Player\PlayerRepositoryContract;
use App\Repositories\Team\TeamRepositoryContract;
use App\Services\BallDontLie\BallDontLieService;
use App\Services\BallDontLie\Contracts\BallDontLieServiceContract;
use Exception;
use Illuminate\Console\Command;

class PopulateTeamsCommand extends Command
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
    protected $signature = 'app:populate-teams-command';

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
        TeamRepositoryContract $teamRepository
    ) {
        try {
            $response = $ballDontLieService->getTeams();
            $teams = data_get($response, 'data');

            if (!$teams) {
                $this->error('No teams found');

                return;
            }

            foreach ($teams as $team) {
                $teamRepository->createTeamFromApi($team);

                $this->info('Team created: ' . data_get($team, 'full_name'));
            }
        } catch (TooManyRequestsException $e) {
            $this->info('The service returns in 30 secods');

            sleep(self::THIRTY_SECONDS);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return;
        }
    }
}
