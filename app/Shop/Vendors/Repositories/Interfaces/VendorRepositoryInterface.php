<?php

namespace App\Shop\Vendors\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Vendors\Vendor;
use Illuminate\Support\Collection;

interface VendorRepositoryInterface extends BaseRepositoryInterface
{
   public function listVendors(string $order = 'id', string $sort = 'desc'): Collection;

    public function createVendor(array $params) : Vendor;

    public function findVendorById(int $id) : Vendor;

    public function updateVendor(array $params): bool;

    public function syncRoles(array $roleIds);

    //public function listRoles() : Collection;

    //public function hasRole(string $roleName) : bool;

    //public function isAuthUser(Employee $employee): bool;
	public function deleteVendor() : bool;
}
