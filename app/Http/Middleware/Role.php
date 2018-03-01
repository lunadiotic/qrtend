<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::user()->can($role.'-access')) {
            return $next($request);
        }
        // return response('Unauthorized', 401);
        return redirect('/home');
    }               
}
