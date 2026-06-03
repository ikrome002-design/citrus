<?php

namespace App\Shop\MembershipVarients\Repositories;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\MembershipVarient\MembershipVarient;
use Illuminate\Support\Collection;

interface MembershipVarientRepositoryInterface extends BaseRepositoryInterface
{
   public function listMembershipVarients(string $order = 'id', string $sort = 'desc') : Collection;
   

}
