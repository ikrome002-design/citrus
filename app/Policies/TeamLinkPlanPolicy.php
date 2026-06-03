<?php

namespace App\Policies;

use App\Models\TeamLinkPlan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamLinkPlanPolicy
{
    use HandlesAuthorization;

    /**
     * if user has can create, update or delete , can view model
     */
    public function before(User $user, TeamLinkPlan $teamLinkPlan)
    {
        if ($user->hasRole(
            [
                'update team link plan',
                'create team link plan',
                'delete team link plan',
                'restore team link plan',
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
    public function view(User $user, TeamLinkPlan $teamLinkPlan): bool
    {
        return  true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->hasPermissionTo('create team link plan', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeamLinkPlan $teamLinkPlan): bool
    {
        return  $user->hasPermissionTo('update team link plan', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeamLinkPlan $teamLinkPlan): bool
    {
        return  $user->hasPermissionTo('delete team link plan', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TeamLinkPlan $teamLinkPlan): bool
    {
        return  $user->hasPermissionTo('restore team link plan', 'admin');
    }
}