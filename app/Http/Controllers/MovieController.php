<?php

namespace App\Http\Controllers;

use App\DTOs\AssessmentDTO;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\StoreUpdateMovieRequest;
use App\Models\Movie;
use App\Repositories\AssessmentRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\MovieRepository;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{

    public function __construct(
        private MovieService $service
    ) {
    }

    public function create()
    {
        return view('movie.create', [
            'categories' => (new CategoryRepository)->getAll(),
        ]);
    }

    public function store(StoreUpdateMovieRequest $request)
    {
        $createdMovie = $this->service->create($request);
        if (!$createdMovie) {
            dd("error create movie");
            session()->flash('error', 'Error creating movie.');
            return back();
        }
        
        session()->flash('success', "{$createdMovie->title} created");
        return redirect()->route('profile.dashboard');
    }

    public function show(int|string $id)
    {
        return view('movie.show', [
            'movie' => (new MovieRepository)->getWithAssessments(['id' => intval($id)])
        ]);
    }

    public function edit(Movie $movie)
    {
        $this->authorize('belongs-to-the-user', $movie);

        return view('movie.edit', [
            'movie' => $movie,
            'categories' => (new CategoryRepository)->getAll(),
        ]);
    }

    public function update(StoreUpdateMovieRequest $request, Movie $movie)
    {
        $this->authorize('belongs-to-the-user', $movie);

        $updatedMovie = $this->service->update($request, $movie->id);
        if ($updatedMovie === false) {
            session()->flash('warning', 'something is wrong.');
            return back();
        }

        session()->flash('success', "Updated movie {$updatedMovie->title}");
        return redirect()->route('profile.dashboard');
    }

    public function destroy(Movie $movie)
    {
        $this->authorize('belongs-to-the-user', $movie);

        $this->service->delete($movie->id);

        session()->flash('success', 'Successfully deleted movie');
        return back();
    }

    public function storeAssessment(StoreAssessmentRequest $request, Movie $movie)
    {
        $this->authorize('assess', $movie);
        
        $dto = AssessmentDTO::makeFromRequest($request);
        $dto->movie_id = $movie->id;
        $dto->user_id = $request->user()->id;
        
        (new AssessmentRepository)->store($dto);

        session()->flash('success', 'Comment made');
        return back();
    }
}
