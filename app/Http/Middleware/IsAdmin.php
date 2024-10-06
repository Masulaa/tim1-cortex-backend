<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    { {
            \Log::info('IsAdmin middleware: ' . Auth::user()->is_admin);

            if (Auth::check() && Auth::user()->is_admin) {
                return $next($request);
            }

            return redirect('/')->with('error', 'Unauthorized access.');
        }
    }
}
