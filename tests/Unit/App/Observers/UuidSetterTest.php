<?php

namespace Tests\Unit\App\Observers;

use App\Models\Model;
use App\Observers\UuidSetter;
use Tests\TestCase;

class UuidSetterTest extends TestCase
{
    /** @test */
    public function it_does_nothing_when_uuid_is_already_set()
    {
        $model = new class() extends Model {
        };
        $model->setAttribute('uuid', $uuid = '123456789');

        $uuidSetter = new UuidSetter();
        $uuidSetter->assignUuid($model);
        $this->assertSame($uuid, $model->getAttribute('uuid'));
    }

    /** @test */
    public function it_assigns_a_random_uuid()
    {
        $model = new class() extends Model {
        };
        $model->setAttribute('uuid', null);

        $uuidSetter = new UuidSetter();
        $uuidSetter->assignUuid($model);
        $this->assertNotNull($model->getAttribute('uuid'));
    }
}
