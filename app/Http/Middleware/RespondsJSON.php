<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RespondsJSON
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('accept', 'application/json');

        return $next($request);
    }
}
