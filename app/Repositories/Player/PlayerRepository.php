<?php

namespace App\Repositories\Player;

use App\Http\Requests\PlayerRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Models\Player;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PlayerRepository extends BaseRepository implements PlayerRepositoryContract
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(Player $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function createPlayerFromApi(array $data): Model
    {
        $model = new $this->model;
        $model->team_id = data_get($data, 'team.id');
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function createPlayerFromRequest(
        array $data
    ): JsonResponse {
        try {
            $player = $this->create($data);

            return response()->json(
                [
                    'message' => 'Player created successfully',
                    'data' => $player?->toArray()
                ],
                Response::HTTP_CREATED
            );

        } catch (Exception $e){
            return response()->json(
                ['error' => $e->getMessage()],
                Response::HTTP_OK
            );
        }
    }

    public function updatePlayerFromRequest(
        array $data,
        int $id
    ): JsonResponse {
        try {
            $player = $this->update($data, $id);

            return response()->json(
                $player,
                Response::HTTP_CREATED
            );
        } catch (ValidationException $e) {
            return response()->json(
                ['errors' => $e->errors()],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (Exception $e){
            Log::error($e->getMessage(), [
                'exception' => $e,
                'code' => 'repository_player_update_error'
            ]);

            return response()->json(
                ['error' => $e->getMessage()],
                Response::HTTP_OK
            );
        }
    }
}
