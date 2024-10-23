<?php

namespace App\Services\BallDontLie;

use App\Exceptions\TooManyRequestsException;
use App\Services\BallDontLie\Contracts\BallDontLieServiceContract;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class BallDontLieService implements BallDontLieServiceContract
{
    /**
     * @var int
     */
    private const PER_PAGE = 100;

    /**
     * @var int
     */
    private const THIRTY_SECONDS = 30;

    /**
     * @var string
     */
    private const PLAYERS_ENDPOINT = 'players';

    /**
     * @var string
     */
    private const TEAMS_ENDPOINT = 'teams';

    public function __construct() {}

    private function sendApiRequest(string $endpoint, array $params): array
    {
        $response = Http::withHeaders([
            'Authorization' => config('balldontlie.api_code')
            ])->get(
                config('balldontlie.api_url') . $endpoint,
                $params
            );

        if ($response->status() === Response::HTTP_TOO_MANY_REQUESTS) {
            throw new TooManyRequestsException('Too many requests.');
        }

        if (!$response->successful()) {
            throw new Exception('Ball dont lie API error: ' . $response->body());
        }

        return $response->json() ?? [];
    }

    public function getPlayers(int $cursor = 0): array
    {
        $params = [
            'per_page' => self::PER_PAGE,
            'cursor' => $cursor
        ];

        $response = $this->sendApiRequest(
            self::PLAYERS_ENDPOINT,
            $params
        );

        return $response;
    }

    public function getTeams(): array
    {
        $response = $this->sendApiRequest(
            self::TEAMS_ENDPOINT,
            []
        );

        return $response;
    }

    public function getTeam(int $teamId): array
    {
        $response = $this->sendApiRequest(
            self::TEAMS_ENDPOINT . '/' . $teamId,
            []
        );

        return $response;
    }
}
