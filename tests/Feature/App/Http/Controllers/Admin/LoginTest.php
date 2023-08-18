<?php

namespace Tests\Feature\App\Http\Controllers\Admin;

use App\Constants\RouteNames;
use App\Models\User;
use App\Services\Jwt\TokenGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\Admin\LoginController
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_unprocessable_entity(): void
    {
        $response = $this->post(URL::route(RouteNames::V1_ADMINS_LOGIN));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_returns_unauthorized_on_invalid_credentials(): void
    {
        $data = [
            'email'    => 'admin@email.com',
            'password' => 'secret123',
        ];

        $response = $this->post(URL::route(RouteNames::V1_ADMINS_LOGIN), $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_returns_unauthorized_when_found_user_is_not_admin(): void
    {
        User::factory()->create([
            'email'    => $email = 'admin@email.com',
            'password' => Hash::make($password = 'secret123'),
        ]);

        $data = compact('email', 'password');

        $response = $this->post(URL::route(RouteNames::V1_ADMINS_LOGIN), $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertNull(Auth::user());
    }

    /** @test */
    public function it_logins_an_admin_and_returns_a_token(): void
    {
        $tokenGenerator = new TokenGenerator(true);
        $this->app->bind(TokenGenerator::class, fn() => $tokenGenerator);

        $user = User::factory()->admin()->create([
            'email'    => $email = 'admin@email.com',
            'password' => Hash::make($password = 'secret123'),
        ]);

        $data = compact('email', 'password');

        $response = $this->post(URL::route(RouteNames::V1_ADMINS_LOGIN), $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $json = $response->json();
        $this->assertArrayHasKey('token', $json);
        $this->assertEquals($user->uuid, Auth::id());
    }
}
