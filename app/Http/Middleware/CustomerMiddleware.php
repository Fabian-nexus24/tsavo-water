<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Ensure the authenticated user is a customer.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'customer') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            return redirect()->route('login')->with('error', 'Please login as a customer.');
        }

        if ($request->user()->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been suspended. Please contact support.');
        }

        return $next($request);
    }
}
