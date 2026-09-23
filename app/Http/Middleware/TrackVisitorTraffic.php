<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorTraffic
{
    /**
     * Handle an incoming request and log visitor traffic.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya catat request GET pada halaman publik (bukan asset/ajax/admin)
        if ($request->isMethod('GET') && !$request->ajax() && !$request->is('admin*') && !$request->is('up')) {
            try {
                $ip = $request->ip();
                $path = $request->path();
                $userAgent = $request->userAgent() ?? '';

                // Deteksi Device sederhana
                $device = 'Desktop';
                if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
                    $device = 'Tablet';
                } elseif (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $userAgent)) {
                    $device = 'Mobile';
                }

                // Deteksi Browser sederhana
                $browser = 'Lainnya';
                if (preg_match('/edg/i', $userAgent)) $browser = 'Edge';
                elseif (preg_match('/chrome/i', $userAgent)) $browser = 'Chrome';
                elseif (preg_match('/safari/i', $userAgent) && !preg_match('/chrome/i', $userAgent)) $browser = 'Safari';
                elseif (preg_match('/firefox/i', $userAgent)) $browser = 'Firefox';
                elseif (preg_match('/opera|opr/i', $userAgent)) $browser = 'Opera';

                // Cegah spam log: jika IP sama buka halaman sama dalam 5 menit terakhir, jangan double-count
                $recent = DB::table('visitor_traffic')
                    ->where('ip_address', $ip)
                    ->where('page_url', $path)
                    ->where('visited_at', '>=', now()->subMinutes(5))
                    ->exists();

                if (!$recent) {
                    DB::table('visitor_traffic')->insert([
                        'ip_address' => $ip,
                        'page_url' => $path === '' ? '/' : $path,
                        'referer' => substr($request->header('referer', ''), 0, 250),
                        'device' => $device,
                        'browser' => $browser,
                        'user_agent' => substr($userAgent, 0, 255),
                        'visited_at' => now(),
                    ]);
                }
            } catch (\Throwable $e) {
                // Jangan biarkan error logging mengganggu rendering halaman pengguna
            }
        }

        return $response;
    }
}
