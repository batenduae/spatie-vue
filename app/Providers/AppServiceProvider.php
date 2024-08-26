<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return ($user->hasRole('super admin')
                ||$user->email==='superadmin@gmail.com'
                ||$user->email==='batenduae@gmail.com'
            ) ? true : null;
        });

        Gate::after(function ($user, $ability) {
            return ($user->hasRole('super admin')
                ||$user->email==='superadmin@gmail.com'
                ||$user->email==='batenduae@gmail.com'
            ); // note this returns boolean
        });
    }
}
