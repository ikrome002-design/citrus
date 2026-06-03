<?php

namespace App\Interfaces;

interface AccountTypeRepositoryInterface
{
    public function all(string $order = 'id', string $sort = 'desc', array $columns = ['*']);
    public function active(string $order = 'id', string $sort = 'desc', array $columns = ['*']);
    public function withTrashed(string $order = 'id', string $sort = 'desc', array $columns = ['*']);
    public function onlyTrashed(string $order = 'id', string $sort = 'desc', array $columns = ['*']);
    public function create(array $data);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function restore(int $id);
}