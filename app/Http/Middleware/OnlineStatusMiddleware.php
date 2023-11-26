<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class OnlineStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $userId = auth()->user()->id;
            Cache::put('user-is-online-' . $userId, true, now()->addMinutes(2));
            User::where('id', $userId)->update(['is_online' => true, 'last_seen' => now()]);
        }
        return $next($request);
    }
}
