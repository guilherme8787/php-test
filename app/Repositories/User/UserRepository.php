<?php

namespace App\Repositories\User;

use App\Http\Resources\UserTokenResource;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate(array $credentials): JsonResponse
    {
        try {
            $user = $this->model->where('login', $credentials['login'])->first();

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken('user-token')->plainTextToken;

            return response()->json(new UserTokenResource($token), Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
