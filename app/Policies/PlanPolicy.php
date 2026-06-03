<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanPolicy
{

    use HandlesAuthorization;

    /**
     * if user has can create, update or delete , can view model
     */
    public function before(User $user, Plan $plan)
    {
        if ($user->hasRole(
            [
                'update main plan',
                'create main plan',
                'delete main plan',
                'restore main plan',
            ],
            'admin'
        )) {
            return $this->view($user, $plan);
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
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('create main plan', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Plan $plan): bool
    {
        return $user->hasRole('update main plan', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Plan $plan): bool
    {
        return $user->hasRole('delete main plan', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Plan $plan): bool
    {
        return $user->hasRole('restore main plan', 'admin');
    }
}
