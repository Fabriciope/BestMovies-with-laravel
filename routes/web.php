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
            ->middleware('verified')
            ->name('movie.create');
            Route::post('/store-movie', [MovieController::class, 'store'])
            ->name('movie.store');
            
        // TODO: mostrar mensagem caso o usuário ainda não possua nenhum filme publicado
        Route::get('/profile/dashboard', [ProfileController::class, 'dashboard'])
            ->name('profile.dashboard');

        Route::delete('movie/destroy/{movie}', [MovieController::class, 'destroy'])
            ->middleware('verified')
            ->name('movie.destroy');
    });

Route::get('/test', function () {
    Auth::logout();
});


require __DIR__ . '/auth.php';
