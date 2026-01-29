<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Http\View\Composers\HseStatsComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use App\Models\User;

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
        View::composer(
            ['hse.dashboard', 'hse.admin_dashboard', 'components.hse-stats', 'logistik.adminlogistik.admin_dashboard', 'logistik.userlogistik.dashboard'],
            HseStatsComposer::class
        );

        // Grant "Super Admin" role all permissions
        Gate::before(function (User $user, $ability) {
            return $user->hasRole('super admin') ? true : null;
        });

        // Custom Blade directive to check for role
        Blade::if('hasrole', function (string $role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });
    }
}
