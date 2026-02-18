<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Schema::defaultStringLength(191);
        
        // Share active users with all views for dropdowns
        View::composer('*', function ($view) {
            if (!$view->offsetExists('users')) {
                $users = User::where('is_active', true)
                    ->orderBy('name')
                    ->get();
                    $bdcAgents = User::role('BDC Agent')->where('is_active', true)
                    ->orderBy('name')
                    ->get();
                     $financeManagers = User::role('Finance Director')->where('is_active', true)
                    ->orderBy('name')
                    ->get();
                     $salesManagers = User::role('Sales Manager')->where('is_active', true)
                    ->orderBy('name')
                    ->get();

                      $serviceAdvisor = User::role('Service Advisor')->where('is_active', true)
                    ->orderBy('name')
                    ->get();

                      
                $view->with(['users'=>$users, 'bdcAgents'=>$bdcAgents, 'financeManagers'=>$financeManagers, 'salesManagers'=>$salesManagers,'serviceAdvisor'=>$serviceAdvisor]);
            }
        });
    }
}
