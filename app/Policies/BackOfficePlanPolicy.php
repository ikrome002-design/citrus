<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BackOfficePlan;
use Illuminate\Auth\Access\HandlesAuthorization;

class BackOfficePlanPolicy
{
    use HandlesAuthorization;

    /**
     * if user has can create, update or delete , can view model
     */
    public function before(User $user, BackOfficePlan $backOfficePlan)
    {
        if ($user->hasRole(
            [
                'update back office plan',
                'create back office plan',
                'delete back office plan',
                'restore back office plan',
            ],
            'admin'
        )) {
            return $this->view($user, $backOfficePlan);
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
    public function view(User $user, BackOfficePlan $backOfficePlan): bool
    {
        return  true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->hasPermissionTo('create back office plan', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BackOfficePlan $backOfficePlan): bool
    {
        return  $user->hasPermissionTo('update back office plan', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BackOfficePlan $backOfficePlan): bool
    {
        return  $user->hasPermissionTo('delete back office plan', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BackOfficePlan $backOfficePlan): bool
    {
        return  $user->hasPermissionTo('restore back office plan', 'admin');
    }
}
