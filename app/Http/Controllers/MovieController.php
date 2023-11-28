<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateMovieRequest;
use App\Models\Movie;
use App\Repositories\CategoryRepository;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{

    public function __construct(
        private MovieService $service
    ) {
    }

    public function index()
    {
        //
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
            return back();
            // TODO: redirecionar com flash messages
        }

        return redirect()
            ->route('profile.dashboard');
        //TODO: redirecionar com flashmessages (filme {$createdMovie->title} criado com sucesso)

    }

    public function show(string $id)
    {
        //
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
            // TODO: msg - something is wrong
            return back();
        }

        // TODO: msg - "updated movie {$updatedMovie->title}"
        return redirect()->route('profile.dashboard');
    }

    public function destroy(Movie $movie)
    {
        $this->authorize('belongs-to-the-user', $movie);

        $this->service->delete($movie->id);

        // TODO: mensagem de sucesso;
        return back();
    }
}
