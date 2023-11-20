<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
    protected static string $model = Category::class;
}