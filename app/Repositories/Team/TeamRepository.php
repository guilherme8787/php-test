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

    private function apiDataToModelData(array $data): array
    {
        return [
            'id' => data_get($data, 'id'),
            'conference' => data_get($data, 'conference'),
            'division' => data_get($data, 'division'),
            'city' => data_get($data, 'city'),
            'name' => data_get($data, 'name'),
            'full_name' => data_get($data, 'full_name'),
            'abbreviation' => data_get($data, 'abbreviation'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function createTeamFromApi(array $data): Model
    {
        return $this->model->create(
            $this->apiDataToModelData($data)
        );
    }
}
