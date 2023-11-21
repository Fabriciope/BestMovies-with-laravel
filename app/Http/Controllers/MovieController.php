<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
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

    public function store(StoreMovieRequest $request)
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

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Movie $movie)
    {
        if (is_null($movie)) {
            //TODO: redirecionar com flashMessage;
            return back();
        }

        if (!$this->service->checkIfTheMovieBelongsToTheUser($movie)) {
            //TODO: redirecionar como flashMessage (vc não pode deletar um filme que não registrou - english)
            dd('vc não pode deletar um filme que não registrou - english');
            return back();
        }

        $this->service->delete($movie->id);

        // TODO: mensagem de sucesso;
        return back();
    }
}
