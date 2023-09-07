<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterUserController extends Controller
{
    public function __construct(
        private UserService $service
    ){}

    public function register()
    {
        return view('auth.register');
    }

    public function store(RegisterUserRequest $request)
    {
        Auth::login($this->service->register($request));

        return redirect()->route('verification.notice');
    }
}
