<?php

namespace App\Http\Controllers\Players;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Repositories\Player\PlayerRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetAllPlayerController extends Controller
{
    public function __construct(private PlayerRepositoryContract $playerRepository)
    {
    }

    public function __invoke()
    {
        return response()->json([
            'data' => $this->playerRepository->all(),
        ], Response::HTTP_OK);
    }
}
