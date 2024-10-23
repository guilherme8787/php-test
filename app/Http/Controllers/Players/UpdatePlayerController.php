<?php

namespace App\Http\Controllers\Players;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerUpdateRequest;
use App\Repositories\Player\PlayerRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UpdatePlayerController extends Controller
{
    public function __construct(private PlayerRepositoryContract $playerRepository)
    {
    }

    public function __invoke(Request $request, int $id)
    {
        $validated = Validator::make(
            $request->all(),
            (new PlayerUpdateRequest())->rules(),
        );

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->playerRepository->updatePlayerFromRequest(
            $validated->validate(),
            $id
        );

        return response()->json([
            'message' => 'Player updated successfully',
        ], Response::HTTP_ACCEPTED);
    }
}
