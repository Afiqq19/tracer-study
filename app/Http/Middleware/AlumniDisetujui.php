<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlumniDisetujui
{
    /**
     * Handle an incoming request.
     * Memastikan alumni sudah disetujui sebelum mengakses menu alumni.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->isAlumni()) {
            abort(403, 'Akses ditolak.');
        }

        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('menunggu.verifikasi')
                ->with('warning', 'Data alumni belum ditemukan.');
        }

        if ($alumni->status_registrasi === 'ditolak') {
            return redirect()->route('menunggu.verifikasi')
                ->with('error', 'Registrasi Anda ditolak. Alasan: ' . $alumni->catatan_penolakan);
        }

        if ($alumni->status_registrasi !== 'disetujui') {
            return redirect()->route('menunggu.verifikasi')
                ->with('info', 'Akun Anda masih menunggu verifikasi dari admin.');
        }

        return $next($request);
    }
}
