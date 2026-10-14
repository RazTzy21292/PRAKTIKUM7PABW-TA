<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        require_once app_path('Helpers/helpers.php');
    }

    public function boot(): void
    {
        // Bagikan $flash (pesan sesi) dan $user (akun login) ke semua view
        View::composer('*', function ($view) {
            if (! $view->offsetExists('flash')) {
                $view->with('flash', session('flash'));
            }
            if (! $view->offsetExists('user')) {
                $view->with('user', Auth::user());
            }
        });
    }
}
