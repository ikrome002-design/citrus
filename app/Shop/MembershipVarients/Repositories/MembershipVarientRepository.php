<?php
namespace App\Shop\MembershipVarients\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\MembershipVarients\Exceptions\CreateMembershipVarientErrorException;
use App\Shop\MembershipVarients\Exceptions\DeleteMembershipVarientErrorException;
use App\Shop\MembershipVarients\Exceptions\MembershipVarientNotFoundErrorException;
use App\Shop\MembershipVarients\Exceptions\UpdateMembershipVarientErrorException;
use App\Shop\MembershipVarients\MembershipVarient;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class MembershipVarientRepository extends BaseRepository implements MembershipVarientRepositoryInterface
{
    /**
     * @var Role
     */
    protected $model;
    /**
     * RoleRepository constructor.
     * @param MembershipVarient $membershipvarient
     */
    public function __construct(MembershipVarient $membershipvarient)
    {
        parent::__construct($membershipvarient);
        $this->model = $membershipvarient;
    }
    /**
     * List all Roles
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listMembershipVarients(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->all(['*'], $order, $sort);
    }

}
