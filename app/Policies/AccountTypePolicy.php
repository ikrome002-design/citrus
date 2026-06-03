<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AccountType;
use Illuminate\Auth\Access\HandlesAuthorization;

class BackOfficePlanPolicy
{
    use HandlesAuthorization;

    /**
     * if user has can create, update or delete , can view model
     */
    public function before(User $user, AccountType $backOfficePlan)
    {
        if ($user->hasRole(
            [
                'update account type',
                'create account type',
                'delete account type',
                'restore account type',
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
    public function view(User $user, AccountType $backOfficePlan): bool
    {
        return  true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->hasPermissionTo('create account type', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AccountType $backOfficePlan): bool
    {
        return  $user->hasPermissionTo('update account type', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AccountType $backOfficePlan): bool
    {
        return  $user->hasPermissionTo('delete account type', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AccountType $backOfficePlan): bool
    {
        return  $user->hasPermissionTo('restore account type', 'admin');
    }
}