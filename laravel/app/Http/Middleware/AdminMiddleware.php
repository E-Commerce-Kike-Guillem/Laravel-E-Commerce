<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Log para depurar (puedes verlo en storage/logs/laravel.log)
        Log::info('Check Admin: ', [
            'user' => Auth::user() ? Auth::user()->email : 'no user',
            'role' => Auth::user() ? Auth::user()->role : 'no role'
        ]);

        if (!Auth::check() || trim(strtolower(Auth::user()->role)) !== 'admin') {
            abort(403, 'ACCÉS DENEGAT: Només administradors.');
        }

        return $next($request);
    }
}