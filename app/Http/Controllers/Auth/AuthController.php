<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\password_reset_token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'promtChangePass', 'reset_password'
        ]);
    }

    public function login()
    {
        return view('Auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = user::where('email', $credentials['email'])->first();
        if( $user)
        if ($user->status == 0) {
            return back()->withErrors([
                'email' => 'account deactivated contact your administrator for more.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {


            $request->session()->regenerate();
            return redirect()->route('home')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }
    public function promtChangePass()
    {
        return view('auth.changepass');
    }

    public function reset_password(Request $request)
    {
        $credentials = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);
        $reset_p = password_reset_token::where('token', $credentials['token'])->where('email', $credentials['email'])->first();
        if ($reset_p) {
            $user = User::where('email', $credentials['email'])->first();
            $user->password = $credentials['password'];
            $user->update();
            return redirect('logout')->with(['message' => 'password changed succcesfully']);
        }
        return redirect()->back()->with(['error' => 'failed to retrived your token ']);
    }

    public function forget_password()
    {
        return view('Auth.resert_password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    }
}
