<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AccessPermission
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
        if (session('id') == null) {
            # code...
            return redirect(asset('login'));
        } else {
            return $next($request);
        }
        
    }
}
