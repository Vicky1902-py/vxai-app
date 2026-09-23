<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Izinkan rute admin dan login tetap bisa diakses agar admin bisa masuk dan mematikan maintenance mode
        if ($request->is('admin*') || $request->is('login*') || $request->is('logout*')) {
            return $next($request);
        }

        try {
            $maintenance = DB::table('global_settings')
                ->where('setting_key', 'maintenance_mode')
                ->value('setting_value');

            if ($maintenance === 'true') {
                // Jika user yang sedang login adalah Super Admin (role_id 1), izinkan lewat
                if (Auth::check() && (int) Auth::user()->role_id === 1) {
                    return $next($request);
                }

                $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');
                return response()->view('errors.maintenance', compact('settings'), 503);
            }
        } catch (\Throwable $e) {
            // Abaikan jika tabel belum siap
        }

        return $next($request);
    }
}
