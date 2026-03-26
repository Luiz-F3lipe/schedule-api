<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $resource, string $action): Response
    {
        if (! $request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if (! $request->user()->hasPermission($resource, $action)) {
            return response()->json(['message' => 'Unauthorized. You do not have permission to ' . $action . ' ' . $resource], 403);
        }

        return $next($request);
    }
}
