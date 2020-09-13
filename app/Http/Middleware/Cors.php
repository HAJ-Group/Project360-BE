<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        // Pre-Middleware Action

        $response = $next($request)
            ->header('Access-Control-Allow-Origin',"*")
            ->header('Access-Control-Allow-Methods',"PUT,POST,DELETE,GET,OPTIONS")
            ->header('Access-Control-Allow-Header',"Accept,Authorization,Content-Type");

        // Post-Middleware Action

        return $response;
    }
}
