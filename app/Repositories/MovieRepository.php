<?php

namespace App\Repositories;

use App\Models\Assessment;
use App\Models\Movie;
use App\Models\User;
use \App\Repositories\AbstractRepository;

class MovieRepository extends AbstractRepository
{
    protected static string $model = Movie::class;

    public function getAllWithRating(?array $filter = null): array
    {
        $foundMovies =  self::getModel()
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    foreach ($filter as $key => $value) {
                        $query->where($key, $value);
                    }
                }
            })->with('assessments')->get();

        $foundMovies->each(function (Movie $movie) {
            $amount = null;
            $sum = null;
            foreach ($movie->assessments->all() as $assessment) {
                $amount++;
                $sum += $assessment->rating;
            }

            if (is_null($amount) && is_null($sum)) {
                $movie->rating = 'Without rating';
            } else {
                $movie->rating = number_format($sum / $amount, 1, '.');
            }
        });

        return $foundMovies->all();
    }

    public function getWithAssessments(?array $filter = null): Movie
    {
        $foundMovie =  self::getModel()
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    foreach ($filter as $key => $value) {
                        $query->where($key, $value);
                    }
                }
            })->with('assessments')->first();

        $amount = null;
        $sum = null;
        foreach ($foundMovie->assessments->all() as $assessment) {
            $amount++;
            $sum += $assessment->rating;
        }

        if (is_null($amount) && is_null($sum)) {
            $foundMovie->rating = 'Without rating';
        } else {
            $foundMovie->rating = number_format($sum / $amount, 1, '.');
        }


        return $foundMovie;
    }
}
