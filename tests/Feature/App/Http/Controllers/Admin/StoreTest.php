<?php

namespace Tests\Feature\App\Http\Controllers\Admin;

use App\Constants\RouteNames;
use App\Http\Resources\UserResource;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\Admin\StoreController
 */
class StoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_unprocessable_entity(): void
    {
        Auth::login(User::factory()->admin()->create());

        $response = $this->post(URL::route(RouteNames::V1_ADMIN_STORE));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_creates_an_admin(): void
    {
        Auth::login(User::factory()->admin()->create());

        $avatar = File::factory()->create();

        $resource = Mockery::mock(UserResource::class);
        $resource->makePartial();
        $resource->shouldReceive('toArray')->withAnyArgs()->once()->andReturn($resourceResponse = ['created']);
        $this->app->bind(UserResource::class, fn() => $resource);

        $data = [
            'email'                 => $email = 'admin@email.com',
            'first_name'            => 'Jon',
            'last_name'             => 'Doe',
            'address'               => '555 1st St',
            'phone_number'          => '555222810',
            'password'              => 'Secret123.',
            'password_confirmation' => 'Secret123.',
            'avatar'                => $avatar->uuid,
        ];

        $response = $this->post(URL::route(RouteNames::V1_ADMIN_STORE), $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertSame($resourceResponse, $response->json());
        $this->assertDatabaseHas(User::class, [
            'email'     => $email,
            'avatar_id' => $avatar->getKey(),
        ]);
    }
}
