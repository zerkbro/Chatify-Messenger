<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->email_verified_at != null) {
            // Session::flash('alert', 'Your email is already verified.');
            // Session::flash('alert-type', 'warning');
            toastr()->error('Your email is already verified!','Hold On!');

            return redirect('/dashboard'); // Change to the desired route for verified users.
        }
        // Session::flash('alert', 'Must verify your email for accessing services!');
        // Session::flash('alert-type', 'danger');
        return $next($request);
    }
}
