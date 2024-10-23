<?php

namespace App\Repositories\Team;

use App\Models\Team;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class TeamRepository extends BaseRepository implements TeamRepositoryContract
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function createTeamFromApi(array $data): Model
    {
        $model = new $this->model;
        $model->fill($data);
        $model->save();

        return $model;
    }
}
