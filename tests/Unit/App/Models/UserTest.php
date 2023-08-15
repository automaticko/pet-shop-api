<?php

namespace Tests\Unit\App\Models;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
}
