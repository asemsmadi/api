<?php

namespace App\Http\Middleware\Api;

use Closure;

class delivery
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!(auth()->check() && auth()->user()->type == 2)) {
            return response(['error'=>'unAuthorized']);
        }
        return $next($request);
    }
}
