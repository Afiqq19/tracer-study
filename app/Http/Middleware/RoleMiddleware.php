<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Memastikan user memiliki role yang sesuai.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user() || !in_array($request->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika user alumni belum verifikasi email, arahkan ke halaman periksa email
        if ($request->user()->role === 'alumni' && !$request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if (!$request->user()->is_active) {
            abort(403, 'Akun Anda telah dinonaktifkan oleh administrator sekolah.');
        }

        return $next($request);
    }
}
