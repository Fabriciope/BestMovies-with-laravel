<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Repositories\CategoryRepository;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    public function __construct(
        private MovieService $service
    ){}

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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
