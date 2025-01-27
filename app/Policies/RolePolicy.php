<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    public function accessAdmin(User $user) {
        return $user->role == 1;
    }
    public function accessUser(User $user) {
        return $user->role == 2;
    }
}
