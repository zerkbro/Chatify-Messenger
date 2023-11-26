<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user->account_status == false && $user->account_inactive_since != null) {
            $disabled_user = $user;
            Auth::logout();
            // Store disabled user information in session flash data
            session()->flash('disabled_user', $disabled_user);
            toastr()->error('Your account is disabled!', 'Access Denied');
            return redirect('/login');

        }
        return $next($request);
    }
}
