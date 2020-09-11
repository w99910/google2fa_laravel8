<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

use App\Support\Google2FAAuthentication;
class Google2FAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authentication=app(Google2FAAuthentication::class)->boot($request);
        if($authentication->isAuthenticated()){
            return $next($request);
        }
        return $authentication->makeRequestOneTimePasswordResponse();
    }
}
