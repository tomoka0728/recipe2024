<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
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
        if ($this->app->runningInConsole()) {
            // CLI環境ではリクエストに依存しない処理を行う
            return;
        }
        
        if (request()->is('admin*')) {
            config(['session.cookie' => config('session.cookie_admin')]);
            } else {
            config(['session.cookie' => config('session.cookie')]);
        }

        Route::middleware('web')
        ->group(base_path('routes/admin.php'));
    }
}
