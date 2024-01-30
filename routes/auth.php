<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->group(function () {
        Route::get('/register', [RegisterUserController::class, 'register'])
            ->name('user.register');
        Route::post('/register/store', [RegisterUserController::class, 'store'])
            ->name('user.store');

        Route::get('/login', [LoginController::class, 'login'])
            ->name('login');
        Route::post('/login/store', [LoginController::class, 'store'])
            ->name('login.store');


        Route::get('/forgot-password', [PasswordResetController::class, 'forgotPassword'])
            ->name('password.forgot');
        
        Route::post('/forgot-password', [PasswordResetController::class, 'sendEmail'])
            ->name('password.email');
        
        Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])
            ->name('password.reset');

        Route::post('/reset-password', [PasswordResetController::class, 'store'])
            ->name('password.store');
    });

Route::middleware('auth')
    ->group(function () {
        Route::get('/verify-email', [VerifyEmailController::class, 'emailVerificationNotice'])
            ->name('verification.notice');

        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verifyEmail'])
            ->middleware('signed')->name('verification.verify');

        Route::post('/email/verification-notification', [VerifyEmailController::class, 'sendVerificationEmail'])
            ->name('verification.send');
    });
