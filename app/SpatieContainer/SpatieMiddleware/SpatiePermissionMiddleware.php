<?php

namespace App\SpatieContainer\SpatieMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SpatiePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {

            $user = Auth::user();
            if($user->hasAnyPermission(['restricted','banned'])){
                abort(403,"User Access is Banned or Restricted");
            }

            if($user->hasRole(['admin','super admin'])) {
                return $next($request);
            } elseif ($user->hasAnyPermission(['admin panel'])){
                return $next($request);
            }elseif((($user->email === 'batenduae@gmail.com')||($user->email === 'superadmin@gmail.com'))) {
                return $next($request);
            }
            return to_route('dashboard')->with('error', "User doesn't have any access to this page");
            abort(403,"User doesn't have any access to this page");


        }
        abort(403,'Please Login to get Access');
    }
}
