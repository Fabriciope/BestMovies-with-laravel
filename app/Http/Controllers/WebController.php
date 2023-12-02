<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\MovieRepository;
use App\Services\MovieService;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function home()
    {
        $moviesByCategory = array();
        $movieRepository = new MovieRepository;
        $movieService = new MovieService($movieRepository);
        
        $categories = (new CategoryRepository)->getAll();
        foreach ($categories as $category) {
            $moviesByCategory[$category->category] = $movieRepository->getAll(['category_id' => $category->id]);
        }

        // TODO: pegar os últimos 20 filmes cadastrados
        // $newMovies = 

        return view('home', [
            'moviesByCategory' => $moviesByCategory,
        ]);
    }
}
