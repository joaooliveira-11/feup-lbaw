<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectPolicy{

    public function create(User $user){
        return !($user->is_admin());
    }

}