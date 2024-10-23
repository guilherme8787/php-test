<?php

namespace App\Http\Controllers\Players;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Repositories\Player\PlayerRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class StorePlayerController extends Controller
{
    public function __construct(private PlayerRepositoryContract $playerRepository)
    {
    }

    public function __invoke(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            (new PlayerRequest())->rules(),
        );

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->playerRepository->createPlayerFromRequest(
            $validated->validate()
        );
    }
}
