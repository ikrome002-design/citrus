<?php

namespace App\Shop\Memberships\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Memberships\Membership;
use Illuminate\Support\Collection;

interface MembershipRepositoryInterface extends BaseRepositoryInterface
{
    public function updateMembership(array $params) : Membership;

    public function listMemberships(string $order = 'id', string $sort = 'desc') : Collection;
    
    public function createMembership(array $params) : Membership;

    public function findMembershipById(int $id) : Membership;

   // public function findProvinces();

    //public function listStates() : Collection;
}
