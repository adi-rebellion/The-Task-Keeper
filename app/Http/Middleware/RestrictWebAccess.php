<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictWebAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('X-Requested-With') !== 'XMLHttpRequest') {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
    }
}
