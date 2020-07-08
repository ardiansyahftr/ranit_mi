<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CekAksesAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session('role') == 2 || session('role') == 8) {
            return $next($request);
        } else {
            return redirect(asset('dashboard'));
        }
        
    }
}
