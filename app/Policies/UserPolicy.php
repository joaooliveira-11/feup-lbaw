<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy {
    use HandlesAuthorization;

    public function update(User $user) {
        return $user->id === Auth::id() || $user->isAdmin();
    }
    
}