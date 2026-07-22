<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $ip = $request->ip();
            $date = now()->toDateString();

            $visitor = Visitor::firstOrCreate(
                ['ip_address' => $ip, 'date' => $date],
                ['user_agent' => $request->userAgent(), 'hits' => 0]
            );

            $visitor->increment('hits');
        } catch (\Exception $e) {
            // Abaikan error pelacakan agar tidak mengganggu pengalaman pengguna
        }

        return $next($request);
    }
}
