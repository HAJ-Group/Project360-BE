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
            ->header('Access-Control-Allow-Origin','*')
            ->header('Access-Control-Allow-Methods','PUT,POST,DELETE,GET,OPTIONS')
            ->header('Access-Control-Allow-Header','Access-Control-Allow-Origin, Content-Type, Accept, Accept-Language, Origin, User-Agent');

        // Post-Middleware Action

        return $response;
    }
}
