<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApplicant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(Auth::check() && Auth::user()->role == $role){
            //0 = User // 1 = Employee // 2 = Admin
            return $next($request);  
        }else{
            return response()->json(["You don't have permission to access this page!"]);
        }
    }
}