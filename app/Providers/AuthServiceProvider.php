<?php

namespace App\Providers;

use App\Models\BackOfficePlan;
use App\Models\BranchPlan;
use App\Models\Plan;
use App\Models\TeamLinkPlan;
use App\Models\User;
use App\Policies\BackOfficePlanPolicy;
use App\Policies\BranchPLanPolicy;
use App\Policies\PlanPolicy;
use App\Policies\TeamLinkPlanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Plan::class => PlanPolicy::class,
        BranchPlan::class => BranchPLanPolicy::class,
        TeamLinkPlan::class => TeamLinkPlanPolicy::class,
        BackOfficePlan::class => BackOfficePlanPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "superadmin" role all permission checks using can()
        Gate::before(function (User $user, $ability) {
            return $user->hasRole('super admin', 'admin');
        });
    }
}