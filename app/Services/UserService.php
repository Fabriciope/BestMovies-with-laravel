<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;

// adicionar uma interface para ter os métodos de crud
class UserService
{
    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function register(RegisterUserRequest $request): \App\Models\User
    {
        $registeredUser = $this->repository->store(
            UserDTO::makeFromRequest($request)
        );

        event(new Registered($registeredUser));

        return $registeredUser;
    }
}
