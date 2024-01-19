<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
    	$role = Auth::user()->role_id;
    	switch ($role) {
    		case 1:
    			return to_route('dashboard');
    			break;
    		case 2:
    			return to_route('admin-panel')
    		default:
        		return $next($request);
    			break;
    	}
    }
}
