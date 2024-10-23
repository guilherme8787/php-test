<?php

namespace App\Services\BallDontLie\Contracts;

interface BallDontLieServiceContract
{
    /**
     * @throws Exception
     * @throws TooManyRequestsException
     */
    public function getPlayers(int $cursor = 0): array;

    /**
     * @throws Exception
     * @throws TooManyRequestsException
     */
    public function getTeams(): array;

    /**
     * @throws Exception
     * @throws TooManyRequestsException
     */
    public function getTeam(int $teamId): array;
}
