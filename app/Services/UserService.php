<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;

class UserService
{
    public function __construct(
        private UserRepository $repository
    ){}

    public function register(RegisterUserRequest $request): User
    {
        $registeredUser = $this->repository->store(
            UserDTO::makeFromRequest($request)
        );

        event(new Registered($registeredUser));

        return $registeredUser;
    }
}