<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(
        private UserService $service
    ) {
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        
        return view('user.profile', [
            'user' => $user,
            'verifiedEmail' => $user->hasVerifiedEmail()
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $updatedUser = $this->service->updateProfile($request);
        if(! $updatedUser instanceof User) {
            return back(); // redirecionar com erros
        }

        return redirect()->route('profile.index'); // redirecionar com sucesso
    }

    public function dashboard(Request $request)
    {
        return view('movie.dashboard');
    }
}
