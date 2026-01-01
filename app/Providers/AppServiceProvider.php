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
        // Share unread notification count with dashboard views
        \Illuminate\Support\Facades\View::composer(
            ['dashboard.index', 'dashboard.tasks', 'dashboard.finance'],
            function ($view) {
                if (\Illuminate\Support\Facades\Auth::check()) {
                    $user = \Illuminate\Support\Facades\Auth::user();
                    $unreadCount = $user->unreadNotifications->count();
                    $notifications = $user->notifications()->latest()->take(5)->get();

                    $view->with('unreadNotificationsCount', $unreadCount)
                        ->with('notifications', $notifications);
                }
            }
        );
    }
}
