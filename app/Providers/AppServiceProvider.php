<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\Notification;


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
    public function boot()
    {
        \View::composer('*', function ($view) {
            if (\Auth::check()) {
                $notifications = Notification::where('emited_to', \Auth::user()->id)
                                ->orderBy('notification_id', 'desc')
                                ->get();
                $view->with('notifications', $notifications);
            }
        });
    }
}
