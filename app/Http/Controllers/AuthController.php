<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Repositories\User\UserRepositoryContract;

class AuthController extends Controller
{
    public function __construct(private UserRepositoryContract $userRepository)
    {
    }

    public function __invoke(AuthenticateRequest $request)
    {
        return $this->userRepository->authenticate(
            $request->only('login', 'password')
        );
    }
}
