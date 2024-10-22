<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepositoryContract;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private UserRepositoryContract $userRepository)
    {
    }

    public function __invoke(Request $request)
    {
        return $this->userRepository->authenticate(
            $request->only('login', 'password')
        );
    }
}
