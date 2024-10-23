<?php

namespace App\Repositories\Player;

use App\Models\Player;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

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

    private function apiDataToModelData(array $data): array
    {
        return [
            'id' => data_get($data, 'id'),
            'first_name' => data_get($data, 'first_name'),
            'last_name' => data_get($data, 'last_name'),
            'position' => data_get($data, 'position'),
            'height' => data_get($data, 'height'),
            'weight' => data_get($data, 'weight'),
            'jersey_number' => data_get($data, 'jersey_number'),
            'college' => data_get($data, 'college'),
            'country' => data_get($data, 'country'),
            'draft_year' => (int) data_get($data, 'draft_year'),
            'draft_round' => (int) data_get($data, 'draft_round'),
            'draft_number' => (int) data_get($data, 'draft_number'),
            'team_id' => data_get($data, 'team.id'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function createPlayerFromApi(array $data): Model
    {
        return $this->model->create(
            $this->apiDataToModelData($data)
        );
    }
}
