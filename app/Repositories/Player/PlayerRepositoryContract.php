<?php

namespace App\Repositories\Player;

use App\Http\Requests\PlayerRequest;
use App\Http\Requests\PlayerUpdateRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

interface PlayerRepositoryContract
{
    /**
     * @param  array  $data
     * @return Model
     */
    public function createPlayerFromApi(array $data): Model;

    /**
     * @param  array  $data
     * @return JsonResponse
     */
    public function createPlayerFromRequest(
        array $data
    ): JsonResponse;

    /**
     * @param  array  $data
     * @param  int  $id
     * @return JsonResponse
     */
    public function updatePlayerFromRequest(
        array $data,
        int $id
    ): JsonResponse;

    /**
    * @param int $id
    * @return Model
    */
    public function delete(int $id);

    /**
    * @param int $id
    * @return Model
    */
    public function find(int $id);

    /**
    * @return Collection
    */
    public function all();
}
