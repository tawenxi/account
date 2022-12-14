<?php

namespace App\Http\Middleware;

use Closure;

class Turbolinks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (session('z-turbolinks')) {
            return $response->header('Turbolinks-Location',url()->full());
        }
        return $response;
    }
}
