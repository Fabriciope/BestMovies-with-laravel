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
        $movieRepository = new MovieRepository;

        $categories = (new CategoryRepository)->getAll();
        $moviesByCategory = array();
        foreach($categories as $category) {
            $moviesByCategory[$category->category] = [];
        }

        $movies = $movieRepository->getAllWithRating();
        foreach ($movies as $movie) {
            foreach($categories as $category) {
                if ($movie->category_id == $category->id) {
                    array_push($moviesByCategory[$category->category], $movie);
                }
            }
        }

        return view('home', [
            'moviesByCategory' => $moviesByCategory,
        ]);
    }
}
