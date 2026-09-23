<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['email' => 'Silakan login terlebih dahulu untuk mengakses halaman ini.']);
        }

        $user = Auth::user();
        $userRoleId = (int) $user->role_id;

        // Map role string to role_id
        // 1: admin, 2: guru, 3: siswa
        $allowed = false;
        foreach ($roles as $role) {
            $role = strtolower(trim($role));
            if (($role === 'admin' || $role === 'superadmin' || $role === '1') && $userRoleId === 1) {
                $allowed = true;
                break;
            } elseif (($role === 'guru' || $role === 'teacher' || $role === '2') && ($userRoleId === 2 || $userRoleId === 1)) {
                // Admin juga diizinkan mengakses menu guru
                $allowed = true;
                break;
            } elseif (($role === 'siswa' || $role === 'student' || $role === '3') && $userRoleId === 3) {
                $allowed = true;
                break;
            }
        }

        if (!$allowed) {
            // Jika user mencoba masuk ke area yang bukan haknya, arahkan ke dashboard masing-masing
            if ($userRoleId === 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($userRoleId === 2) {
                return redirect()->route('guru.dashboard');
            } elseif ($userRoleId === 3) {
                return redirect()->route('siswa.dashboard');
            }

            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}
