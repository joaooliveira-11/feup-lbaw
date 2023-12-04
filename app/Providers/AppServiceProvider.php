<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
    public function boot()
    {
        \View::composer('*', function ($view) {
            if (\Auth::check()) {
                $notifications = \DB::table('notification')
                    ->where('emited_to', \Auth::user()->id)
                    ->orderBy('notification_id', 'desc')
                    ->get();
                $view->with('notifications', $notifications);
            }
        });
    }
}
