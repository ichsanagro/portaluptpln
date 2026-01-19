<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Http\View\Composers\HseStatsComposer;
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
        View::composer(
            ['hse.dashboard', 'hse.admin_dashboard', 'components.hse-stats', 'logistik.adminlogistik.admin_dashboard', 'logistik.userlogistik.dashboard'],
            HseStatsComposer::class
        );
    }
}
