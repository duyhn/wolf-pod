<?php

namespace App\Providers;

use App\Role;
use App\User;
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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();

        
        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: User actions
        Gate::define('user_action_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Extract management
        Gate::define('extract_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Links
        Gate::define('link_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('link_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('link_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('link_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('link_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('link_crawler', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Extract manager
        Gate::define('extract_manager_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('extract_manager_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('extract_manager_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('extract_manager_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('extract_manager_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

    }
}
