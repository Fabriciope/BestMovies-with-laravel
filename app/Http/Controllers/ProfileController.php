<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Repositories\MovieRepository;
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
            session()->flash('warning', 'Something is wrong.');
            return back();
        }

        session()->flash('success', 'Updated profile.');
        return redirect()->route('profile.index');
    }

    public function dashboard(Request $request)
    {
        $usersMovie = (new MovieRepository)->getAll(['user_id' => $request->user()->id]);
        return view('movie.dashboard', [
            'movies' => $usersMovie,
        ]);
    }
}
