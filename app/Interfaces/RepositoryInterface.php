<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function getAll(?array $filter = null): array;
    public function getAllWithPagination(int $totalPerPage = 5, ?array $filter = null): LengthAwarePaginator;
    public function findOne(string|int $id): ?Model;
    public function store(DTOInterface $dto): Model;
    public function update(DTOInterface $dto): Model|bool;
    public function delete(string|int $id): void;

}