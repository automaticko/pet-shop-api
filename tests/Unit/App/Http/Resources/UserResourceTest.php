<?php

namespace Tests\Unit\App\Http\Resources;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    /** @test */
    public function it_has_correct_fields(): void
    {
        $data = [
            'uuid'       => 'uuid',
            'first_name' => 'Jon',
            'last_name'  => 'Doe',
            'email'      => 'jon@doe.com',
        ];

        $model = new User($data);

        $resource = new UserResource($model);
        $response = $resource->toArray(Request::instance());

        $this->assertEqualsCanonicalizing($data, $response);
    }
}
