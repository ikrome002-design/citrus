<?php

namespace App\Repositories;

use App\Interfaces\AccountTypeRepositoryInterface;
use App\Models\AccountType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class AccountTypeRepository implements AccountTypeRepositoryInterface
{
    public function all(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return AccountType::all($columns, $order, $sort);
    }
    public function active(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return AccountType::where('status', 'active');
    }
    public function withTrashed(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return AccountType::withTrashed();
    }
    public function onlyTrashed(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return AccountType::withTrashed();
    }
    public function create(array $data)
    {
        try {
            AccountType::create($data);
        } catch (QueryException $e) {
            throw new \Exception(message: 'Account type was not created');
        }
    }
    public function find(int $id)
    {
        try {

            return AccountType::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception(message: 'Account type not found');
        } catch (\Throwable $e) {
            throw new \Exception(message: 'There was an error. Please try again');
        }
    }
    public function update(int $id, array $data)
    {
        try {
            return AccountType::whereId($id)->update($data);
        } catch (ModelNotFoundException $e) {
            throw new \Exception(message: 'Account type not found');
        } catch (QueryException $e) {
            throw new \Exception(message: 'Account type was not updated');
        } catch (\Throwable $e) {
            throw new \Exception(message: 'There was an error. Please try again');
        }
    }
    public function delete(int $id)
    {
        try {
            AccountType::destroy($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception(message: 'Account type not found');
        } catch (QueryException $e) {
            throw new \Exception(message: 'Account type was not updated');
        } catch (\Throwable $e) {
            throw new \Exception(message: 'There was an error. Please try again');
        }
    }
    public function restore(int $id)
    {
        try {
            return  AccountType::whereId($id)->restore()->update(['status' => 'active']);
        } catch (ModelNotFoundException $e) {
            throw new \Exception(message: 'Account type not found');
        } catch (QueryException $e) {
            throw new \Exception(message: 'Account type was not restored');
        } catch (\Throwable $e) {
            throw new \Exception(message: 'There was an error. Please try again');
        }
    }
}
