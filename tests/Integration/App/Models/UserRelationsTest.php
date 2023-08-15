<?php

namespace Tests\Integration\App\Models;

use App\Models\File;
use App\Models\User;

class UserRelationsTest extends RelationsTestCase
{
    /** @test */
    public function it_belongs_to_a_file(): void
    {
        $model   = User::factory()->create();
        $related = $model->avatar()->first();

        $this->assertInstanceOf(File::class, $related);
    }
}
