<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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
        // Admin Gate
        Gate::define('admin', function ($user) {
            // Ensure $user exists and role is admin
            return $user && $user->role === 'admin';
        });

        // Force HTTPS for all URLs in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
