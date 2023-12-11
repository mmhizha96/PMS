<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role_id == 1) {
            return redirect()->route('admin_home');
        } elseif (Auth::user()->role_id == 2 || Auth::user()->role_id == 3) {
            return redirect()->route('user_home');
        } else {
            return redirect()->back()->with(
                ['errors' => "opration not allowed"]
            );
        }
    }
}
