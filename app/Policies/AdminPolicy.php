<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy {
    use HandlesAuthorization;

    public function ban(User $userToBan) {
        return $userToBan->isAdmin();
    }
    
}