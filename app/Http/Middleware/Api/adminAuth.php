<?php

namespace App\Http\Middleware\Api;

use Closure;

class adminAuth
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
        if (!auth()->check()) {
            return response()->json(
                [
                    'error' => 'UnAuthorization'
                ]
            );
        }
        if (!(auth()->user()->type == 1)) {
            return response()->json(
                [
                    'error' => 'UnAuthorization'
                ]
            );

        }
        return $next($request);
    }
}
