<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [WebController::class, 'home'])
    ->name('home');

Route::get('/movie/{id}', [MovieController::class, 'show'])
    ->name('movie.show');

Route::middleware('auth')
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'profile'])
            ->name('profile.index');

        Route::post('/user/update', [ProfileController::class, 'update'])
            ->name('user.update');

        Route::get('/profile/dashboard', [ProfileController::class, 'dashboard'])
            ->name('profile.dashboard');
    });

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/add-movie', [MovieController::class, 'create'])
            ->name('movie.create');

        Route::post('/store-movie', [MovieController::class, 'store'])
            ->name('movie.store');


        Route::get('/movie/edit/{movie}', [MovieController::class, 'edit'])
            ->name('movie.edit');

        Route::put('/movie/update/{movie}', [MovieController::class, 'update'])
            ->name('movie.update');

        Route::delete('/movie/destroy/{movie}', [MovieController::class, 'destroy'])
            ->name('movie.destroy');

        
        Route::post('/movie/store-assessment/{movie}', [MovieController::class, 'storeAssessment'])
            ->name('assessment.store');
    });

Route::get('/test', function () {
    Auth::logout();
});


require __DIR__ . '/auth.php';
