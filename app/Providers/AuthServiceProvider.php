<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Assessment;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('belongs-to-the-user', function (User $user, Movie $movie) {
            return $user->id == $movie->user_id;
        });

        Gate::define('assess', function(User $user, Movie $movie) {
            $assessmentsCount = Assessment::where('movie_id', $movie->id)
                                            ->where('user_id', $user->id)
                                            ->count();
            return $user->id != $movie->user_id && $assessmentsCount == 0;
        });
    }
}
