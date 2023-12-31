<?php

namespace App\Providers;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
        Project::class => ProjectPolicy::class,
        User::class => UserPolicy::class,
        Comment::class => CommentPolicy::class,
        Message::class => MessagePolicy::class,
        Invite::class => InvitePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void {
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return URL::to('/') . '/password/recover?token='.$token;
        }); 
    }
}
