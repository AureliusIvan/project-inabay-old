<?php

namespace App\Providers;

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

        //
        Gate::define('superadmin', function($user){
            if($user->role_id == 0 || $user->role_id == 1) {
                return true;
            }else {
                return false;
            }
        });

        Gate::define('admin', function($user){
            if($user->role_id == 0 || $user->role_id == 1 || $user->role_id == 2) {
                return true;
            }else {
                return false;
            }
        });

        Gate::define('finance', function($user){
            if($user->role_id == 0 || $user->role_id == 1 || $user->role_id == 2 || $user->role_id == 5) {
                return true;
            }else {
                return false;
            }
        });

        Gate::define('office', function($user){
            if($user->role_id == 0 || $user->role_id == 1 || $user->role_id == 2 || $user->role_id == 5) {
                return true;
            }else {
                return false;
            }
        });

        Gate::define('member', function($user){
            if($user->role_id == 0 || $user->role_id == 3){
                return true;
            }else{
                return false;
            }
//            return $user->role_id == 3;
        });
    }
}
