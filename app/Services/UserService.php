<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

// adicionar uma interface para ter os métodos de crud
class UserService
{
    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function register(RegisterUserRequest $request): User
    {
        $registeredUser = $this->repository->store(
            UserDTO::makeFromRequest($request)
        );

        event(new Registered($registeredUser));

        return $registeredUser;
    }

    public function updateProfile(UpdateProfileRequest $request): User|bool
    {
        $user = $request->user();
        if (! is_null($user->photo) && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $userDTO = UserDTO::makeFromRequest($request, $user->id); 
        if (!is_null($userDTO->photo)) {
            $userDTO->photo = Storage::disk('public')
            ->put('photos', $request->file('photo'));
        }

        return $this->repository->update($userDTO);
    }
}
