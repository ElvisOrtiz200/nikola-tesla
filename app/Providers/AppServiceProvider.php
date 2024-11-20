<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            // Verifica que la vista no sea la de login
            if (!request()->is('api/auth/login')) {
                if (JWTAuth::getToken()) {
                    if ($user = JWTAuth::parseToken()->authenticate()) {
                        $view->with('idrol', $user->idrol);
                    }
                }
            }
        });
    }
}
