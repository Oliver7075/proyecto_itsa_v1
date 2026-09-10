<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureResourceAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $requestedPath = trim((string) $request->path(), '/');
        if ($requestedPath === '' || $requestedPath === 'home') {
            return $next($request);
        }

        $user = auth()->user();

        if (!$user || !$user->canAccess($requestedPath)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
