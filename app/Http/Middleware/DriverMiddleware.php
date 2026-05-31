<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DriverMiddleware
{
    /**
     * Ensure the authenticated user is a driver.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'driver') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            return redirect()->route('driver.login')->with('error', 'Please login as a driver.');
        }

        if ($request->user()->status !== 'active') {
            auth()->logout();
            return redirect()->route('driver.login')->with('error', 'Your account has been suspended. Please contact your manager.');
        }

        return $next($request);
    }
}
