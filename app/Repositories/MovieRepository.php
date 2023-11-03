<?php  

namespace App\Repositories;

use App\Models\Movie;
use \App\Repositories\AbstractRepository;

class MovieRepository extends AbstractRepository
{
    protected static string $model = Movie::class;
}