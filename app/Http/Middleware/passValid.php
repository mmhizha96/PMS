<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits;
use App\Http\Controllers\Traits\pass_reset_trait;

class passValid
{
    use pass_reset_trait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {




        if (Hash::check(Auth::user()->email,  Auth::user()->password)) {

            $this->createToken();

            return redirect()->route('reset_password_view');
        }


        return $next($request);
    }
}
