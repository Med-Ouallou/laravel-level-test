<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });

        \Illuminate\Support\Facades\Gate::define('isUser', function ($user) {
            return $user->role === 'user';
        });

        \Illuminate\Support\Facades\Gate::define('access-admin', function ($user) {
            return in_array($user->role, ['admin', 'user']);
        });

        \Illuminate\Support\Facades\Gate::define('add-players', function ($user) {
            return in_array($user->role, ['admin', 'user']);
        });

        \Illuminate\Support\Facades\Gate::define('edit-players', function ($user) {
            return $user->role === 'admin';
        });

        \Illuminate\Support\Facades\Gate::define('delete-players', function ($user) {
            return $user->role === 'admin';
        });
    }
}
