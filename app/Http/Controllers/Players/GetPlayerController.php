<?php

namespace App\Http\Controllers\Players;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Repositories\Player\PlayerRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetPlayerController extends Controller
{
    public function __construct(private PlayerRepositoryContract $playerRepository)
    {
    }

    public function __invoke(int $id)
    {
        $player = $this->playerRepository->find($id);

        return response()->json([
            'data' => $player,
        ], Response::HTTP_OK);
    }
}
