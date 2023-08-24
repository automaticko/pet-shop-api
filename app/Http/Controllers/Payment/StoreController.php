<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Keys;
use App\Http\Requests\Payment\StoreRequest;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): SymfonyResponse
    {
        $details = $request->get(Keys::DETAILS);

        return Response::make('coming soon...' . json_encode($details));
    }
}
