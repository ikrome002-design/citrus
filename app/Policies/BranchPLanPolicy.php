<?php

namespace App\Policies;

use App\Models\BranchPlan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchPLanPolicy
{
    use HandlesAuthorization;

    /**
     * if user has can create, update or delete , can view model
     */
    public function before(User $user, BranchPlan $branchPlan)
    {
        if ($user->hasRole(
            [
                'update branch plan',
                'create branch plan',
                'delete branch plan',
                'restore branch plan',
            ],
            'admin'
        )) {
            return $this->view($user, $branchPlan);
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BranchPlan $branchPlan): bool
    {
        return  true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->hasPermissionTo('create branch plan', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BranchPlan $branchPlan): bool
    {
        return  $user->hasPermissionTo('update branch plan', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BranchPlan $branchPlan): bool
    {
        return  $user->hasPermissionTo('delete branch plan', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BranchPlan $branchPlan): bool
    {
        return  $user->hasPermissionTo('restore branch plan', 'admin');
    }
}