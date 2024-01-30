<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendEmail(PasswordResetRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only(['email'])
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withInput($request->only('email'))
                    ->withErrors(['error' => __($status)]);
    }

    public function reset(string $token)
    {
        return view('auth.reset-password', compact('token'));
    }

    public function store(PasswordResetRequest $request)
    {
        $status = Password::reset(
            $request->only(['email', 'password', 'password_confirmation', 'token']),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withInput($request->only('email'))
                    ->withErrors(['error' => __($status)]);
    }
}
