<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetupMiddleware
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
        $role=Auth::user()->getRoleNames()->first();
        if($role == 'Super Admin')
        {
            return $next($request);
        }
        else{
            return redirect()->back();
        }

    }
}
