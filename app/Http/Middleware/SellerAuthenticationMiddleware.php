<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth('seller')->check()) {
            return redirect()->route('seller-login');
        }

        return $next($request);
    }
}
