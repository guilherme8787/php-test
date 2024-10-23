<?php

namespace App\Http\Controllers\Players;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Repositories\Player\PlayerRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeletePlayerController extends Controller
{
    public function __construct(private PlayerRepositoryContract $playerRepository)
    {
    }

    public function __invoke(int $id)
    {
        $this->playerRepository->delete($id);

        return response()->json([
            'message' => 'Player deleted successfully',
        ], Response::HTTP_ACCEPTED);
    }
}
