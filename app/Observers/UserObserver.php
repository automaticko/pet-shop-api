<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function __construct(private readonly UuidSetter $uuidSetter)
    {
    }

    public function creating(User $user): void
    {
        $this->uuidSetter->assign($user);
    }
}
