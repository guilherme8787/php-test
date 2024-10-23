<?php

namespace App\Repositories\Team;

use Illuminate\Database\Eloquent\Model;

interface TeamRepositoryContract
{
    /**
    * @param  array  $data
    * @return Model
    */
    public function createTeamFromApi(array $data): Model;

    /**
    * @param int $id
    * @return Model
    */
    public function find(int $id);
}
