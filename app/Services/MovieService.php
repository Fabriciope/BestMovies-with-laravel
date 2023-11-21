<?php

namespace App\Services;

use App\DTOs\MovieDTO;
use App\Http\Requests\StoreMovieRequest;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MovieService
{
    public function __construct(
        private MovieRepository $repository
    ) {
    }

    public function create(StoreMovieRequest $request): Movie|bool
    {
        $movieDTO = MovieDTO::makeFromRequest($request);
        $movieDTO->user_id = Auth::user()->id;
        
        if ($movieDTO->duration == '0:0') {
            return false;
        }

        $movieDTO->poster = Storage::disk('public')->put('posters', $request->file('poster'));

        $createdMovie = $this->repository->store($movieDTO);
        if (!$createdMovie instanceof Movie) {
            return false;
        }

        return $createdMovie;
    }
    
    public function delete(string|int $id)
    {   
        $this->repository->delete(intval($id));
    }
    
    public function checkIfTheMovieBelongsToTheUser(Movie $movie): bool
    {
        return Auth::user()->id == $movie->user_id;
    }
}
