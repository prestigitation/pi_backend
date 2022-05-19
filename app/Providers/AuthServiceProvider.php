<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

use App\Helpers\Enums\DashboardRoles;
use App\Helpers\Functions\FilterRolesNames;

use App\Helpers\Traits\EnumHelper;

class AuthServiceProvider extends ServiceProvider
{

    public function __construct()
    {
        $this->roleNameFilter = new FilterRolesNames();
    }
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        /**
         * Defining the user Roles
         */
        Gate::define('isAdmin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('isUser', function (User $user) {
            return $user->isUser();
        });

        Gate::define('setRole', function (User $user) {
            $roles = [
                DashboardRoles::ROLE_ADMIN,
                DashboardRoles::ROLE_OWNER,
            ];
            return count(array_intersect(
                EnumHelper::getNames($user->roles->toArray()),
                EnumHelper::getValues($roles)
            ));
        });

        Gate::define('accessQA', function (User $user) {
            $roles = [
                DashboardRoles::ROLE_ADMIN,
                DashboardRoles::ROLE_OWNER,
                DashboardRoles::ROLE_LABORANT,
                DashboardRoles::ROLE_TEACHER,
            ];
            return count(array_intersect(
                EnumHelper::getNames($user->roles->toArray()),
                EnumHelper::getValues($roles)
            ));
        });

        Gate::define('accessDates', function (User $user) {
            $roles = [
                DashboardRoles::ROLE_ADMIN,
                DashboardRoles::ROLE_OWNER,
                DashboardRoles::ROLE_LABORANT,
            ];
            return count(array_intersect(
                EnumHelper::getNames($user->roles->toArray()),
                EnumHelper::getValues($roles)
            ));
        });

        Gate::define('watchSelfSchedule', function (User $user) {
            $roles = [
                DashboardRoles::ROLE_ADMIN,
                DashboardRoles::ROLE_TEACHER,
                DashboardRoles::ROLE_STUDENT,
            ];
            return count(array_intersect(
                EnumHelper::getNames($user->roles->toArray()),
                EnumHelper::getValues($roles)
            ));
        });

        Gate::define('accessSchedule', function (User $user) {
            $roles = [
                DashboardRoles::ROLE_ADMIN,
                DashboardRoles::ROLE_OWNER,
                DashboardRoles::ROLE_LABORANT,
                DashboardRoles::ROLE_TEACHER,
            ];
            return count(array_intersect(
                EnumHelper::getNames($user->roles->toArray()),
                EnumHelper::getValues($roles)
            ));
        });
    }
}
