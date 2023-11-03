<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WebController::class, 'home'])
    ->name('home');

Route::middleware('auth')
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'profile'])
            ->name('profile.index');

        Route::post('/user/update', [ProfileController::class, 'update'])
            ->name('user.update');

        Route::get('/add-movie', [MovieController::class, 'create'])
            ->name('movie.create');
    });

Route::get('/test', function () {
    Auth::logout();
});


require __DIR__ . '/auth.php';
