<?php

namespace App\Repositories\User;

use Illuminate\Http\JsonResponse;

interface UserRepositoryContract
{
    /**
     * Authenticate the user.
     *
     * @param  array  $credentials
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(array $credentials): JsonResponse;
}
