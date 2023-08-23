<?php

namespace Tests\Integration\App\Models;

use App\Models\File;
use App\Models\Order;
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

    /** @test */
    public function it_has_orders(): void
    {
        $model = User::factory()->create();
        Order::factory()->usingUser($model)->count(parent::COUNT)->create();

        $related = $model->orders()->get();

        $this->assertCorrectRelation($related, Order::class);
    }
}
