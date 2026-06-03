<?php

namespace App\Shop\Memberships\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Memberships\Exceptions\MembershipInvalidArgumentException;
use App\Shop\Memberships\Exceptions\MembershipNotFoundException;
use App\Shop\Memberships\Repositories\Interfaces\MembershipRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Shop\Memberships\Membership;
use Illuminate\Support\Collection;

class MembershipRepository extends BaseRepository implements MembershipRepositoryInterface
{
    /**
     * MembershipRepository constructor.
     * @param Membership $membership
     */
    public function __construct(Membership $membership)
    {
        parent::__construct($membership);
        $this->model = $membership;
    }

    /**
     * List all the countries
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listMemberships(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->model->get();
    }

    /**
     * @param array $params
     * @return Membership
     */
    public function createMembership(array $params) : Membership
    {
        return $this->create($params);
    }

    /**
     * Find the country
     *
     * @param $id
     * @return Membership
     * @throws MembershipNotFoundException
     */
    public function findMembershipById(int $id) : Membership
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new MembershipNotFoundException('Membership not found.');
        }
    }

    /**
     * Show all the provinces
     *
     * @return mixed
     */
    public function findProvinces()
    {
        return $this->model->provinces;
    }

    /**
     * Update the membership
     *
     * @param array $params
     *
     * @return Membership
     * @throws MembershipNotFoundException
     */
    public function updateMembership(array $params) : Membership
    {
        try {
            $this->model->update($params);
            return $this->findMembershipById($this->model->id);
        } catch (QueryException $e) {
            throw new MembershipInvalidArgumentException($e->getMessage());
        }
    }

    /**
     *
     * @return Collection
     */
    public function listStates() : Collection
    {
        return $this->model->states()->get();
    }


}
