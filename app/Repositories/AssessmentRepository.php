<?php

namespace App\Repositories;

use App\Models\Assessment;
use App\Repositories\AbstractRepository;

class AssessmentRepository extends AbstractRepository
{
    protected static string $model = Assessment::class;
}