<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class RedirectIfLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Session::get('is_login') == true || Session::get('is_login') != null) {
            return redirect('dashboard');
        }

        return $next($request);
    }
}
