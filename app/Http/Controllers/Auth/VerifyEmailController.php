<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function emailVerificationNotice()
    {
        if(request()->user()->hasVerifiedEmail()) {
            return back();// redirecionar com mensagem
        }
        
        return view('auth.verification-notice');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()
            ->route('profile.index');// redirecionar com uma mensagem de sucesso
    }

    public function sendVerificationEmail(Request $request)
    {
        if($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('profile.index'));
        }

        $request->user()->sendEmailVerificationNotification();

        return redirect()// TODO: redirecionar com uma flash message 
            ->route('profile.index');
    }
}
