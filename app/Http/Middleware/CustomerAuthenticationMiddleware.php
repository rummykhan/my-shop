<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerAuthenticationMiddleware
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
        if (!auth('customer')->check()) {
            return redirect()->route('customer-login');
        }
        return $next($request);
    }
}
