<?php

namespace Tests\Unit\App\Models;

use App\Models\File;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_defines_an_avatar_relation(): void
    {
        $model    = new User();
        $relation = $model->avatar();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(File::class, $relation->getRelated());
        $this->assertSame('id', $relation->getOwnerKeyName());
        $this->assertSame('avatar_id', $relation->getForeignKeyName());
        $this->assertSame('avatar', $relation->getRelationName());
    }

    /** @test */
    public function it_defines_an_orders_relation(): void
    {
        $model    = new User();
        $relation = $model->orders();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(Order::class, $relation->getRelated());
        $this->assertSame('id', $relation->getLocalKeyName());
        $this->assertSame('user_id', $relation->getForeignKeyName());
    }

    /** @test */
    public function it_sets_auth_id_name_as_uuid(): void
    {
        $model = new User();

        $this->assertSame('uuid', $model->getAuthIdentifierName());
    }

    /** @test */
    public function it_returns_if_the_user_is_admin(): void
    {
        $user  = User::factory()->make(['avatar_id' => 1]);
        $admin = User::factory()->admin()->make(['avatar_id' => 1]);

        $this->assertFalse($user->isAdmin());
        $this->assertTrue($admin->isAdmin());
    }
}
