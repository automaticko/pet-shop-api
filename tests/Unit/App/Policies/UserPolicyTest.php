<?php

namespace Tests\Unit\App\Policies;

use App\Models\User;
use App\Policies\UserPolicy;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    /** @test */
    public function it_says_if_user_can_create_an_admin(): void
    {
        $user   = User::factory()->make(['avatar_id' => 1]);
        $admin  = User::factory()->admin()->make(['avatar_id' => 1]);
        $policy = new UserPolicy();

        $this->assertFalse($policy->createAdmin($user));
        $this->assertTrue($policy->createAdmin($admin));
    }
}
