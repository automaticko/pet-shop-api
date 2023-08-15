<?php

namespace Tests\Unit\App\Models;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class FileTest extends TestCase
{
    /** @test */
    public function it_defines_a_users_relation(): void
    {
        $model    = new File();
        $relation = $model->users();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
        $this->assertSame('id', $relation->getLocalKeyName());
        $this->assertSame('avatar_id', $relation->getForeignKeyName());
    }
}
