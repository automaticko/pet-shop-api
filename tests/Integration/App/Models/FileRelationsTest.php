<?php

namespace Tests\Integration\App\Models;

use App\Models\File;
use App\Models\User;

class FileRelationsTest extends RelationsTestCase
{
    /** @test */
    public function it_has_users(): void
    {
        $model = File::factory()->create();
        User::factory()->usingFile($model)->count(parent::COUNT)->create();

        $related = $model->users()->get();

        $this->assertCorrectRelation($related, User::class);
    }
}
