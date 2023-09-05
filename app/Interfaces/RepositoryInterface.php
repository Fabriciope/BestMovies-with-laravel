<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function getAll(?array $filter): array;
    public function getAllWithPagination(int $totalPerPage = 5, int $currentPage = 1, ?array $filter = null): LengthAwarePaginator;
}