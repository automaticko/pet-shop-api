<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Jwt\TokenGenerator;
use Auth;
use Carbon\CarbonImmutable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class LoginController extends Controller
{
    /**
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function __invoke(LoginRequest $request, TokenGenerator $tokenGenerator): SymfonyResponse
    {
        if (!Auth::validate($request->validated())) {
            throw new AuthenticationException();
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            Auth::forgetUser();

            throw new AuthenticationException();
        }

        $now   = CarbonImmutable::now();
        $token = $tokenGenerator->generate($request->getHost(), $now, $user->uuid);

        $user->last_login_at = $now;
        $user->save();

        return Response::json(['token' => $token->toString()])->setStatusCode(SymfonyResponse::HTTP_CREATED);
    }
}
