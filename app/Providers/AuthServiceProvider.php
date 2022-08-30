<?php

namespace App\Providers;

use Laravel\Passport\Passport;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('isSuper', function($user) {
           return $user->role == 1;
        });
        Gate::define('isWeb', function($user) {
            return $user->role == 2 || $user->role == 1;
        });
        Gate::define('isMobile', function($user) {
            return $user->role == 3;
        });
        Gate::define('isExe', function($user) {
            return $user->role == 4;
        });
        Gate::define('isCompany', function($user) {
            return $user->role == 5;
        });
    }
}
    