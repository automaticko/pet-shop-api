<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Keys;
use App\Http\Resources\UserResource;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): SymfonyResponse
    {
        $data = $request->except([
            Keys::MARKETING,
            Keys::PASSWORD,
            Keys::PASSWORD_CONFIRMATION,
            Keys::AVATAR,
        ]);

        /** @var \App\Models\File $file */
        $file = File::where('uuid', $request->get(Keys::AVATAR))->first();

        $data['avatar_id']    = $file->getKey();
        $data['is_admin']     = true;
        $data['is_marketing'] = (bool) $request->get(Keys::MARKETING);
        $data['password']     = Hash::make($request->get(Keys::PASSWORD));

        $user     = User::create($data);
        $resource = App::make(UserResource::class, ['resource' => $user]);

        return Response::make($resource)->setStatusCode(SymfonyResponse::HTTP_CREATED);
    }
}
