<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (auth()->user()->role == User::ROLE_ADMIN) {
            return $next($request);
        }

        if (auth()->user()->role !== $role) {
            abort(HttpResponse::HTTP_FORBIDDEN, "You don't have permission.");
        }

        return $next($request);
    }
}
