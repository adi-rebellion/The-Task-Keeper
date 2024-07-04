<?php

namespace App\Interfaces;
use Illuminate\Contracts\Pagination\Paginator;


interface CrudInterface
{
    public function getAll(array $filterData): ?Paginator;

    public function getById(int $id): ?object;

    public function create(array $inputData) : ?object;


}
