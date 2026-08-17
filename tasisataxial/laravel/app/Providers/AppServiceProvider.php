<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Schema::defaultStringLength(191);
        // Paginator::useBootstrap();

            Gate::define("superadmin",function(User $user){
            return $user->role_as==0;
        });

        Gate::define("admins",function(User $user){
            return $user->role_as==1;
        });

        Gate::define("users",function(User $user){
            return $user->role_as==4;
        });

    }
}
