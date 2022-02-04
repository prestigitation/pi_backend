<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

use App\Helpers\Enums\DashboardRoles;
use App\Helpers\Functions\FilterRolesNames;

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
            // if ($user->isAdmin()) {
            //     return true;
            // }

            // for simplicity
            return $user->isAdmin();
        });

        Gate::define('isUser', function (User $user) {
            // if ($user->isUser()) {
            //     return true;
            // }

            // for simplicity
            return $user->isUser();
        });

        Gate::define('setRole', function (User $user) {
            $roles = [
                DashboardRoles::ROLE_ADMIN->value,
                DashboardRoles::ROLE_OWNER->value,
            ];
            return count(array_intersect(
                $this->roleNameFilter->getRolesNames($user->roles->toArray()),
                $roles
            ));
        });
    }
}
