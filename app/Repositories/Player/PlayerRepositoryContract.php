<?php

namespace App\Repositories\Player;

use Illuminate\Database\Eloquent\Model;

interface PlayerRepositoryContract
{
    /**
     * @param  array  $data
     * @return Model
     */
    public function createPlayerFromApi(array $data): Model;
}
