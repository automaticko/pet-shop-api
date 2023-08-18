<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function createAdmin(User $user): bool
    {
        return $user->isAdmin();
    }
}
