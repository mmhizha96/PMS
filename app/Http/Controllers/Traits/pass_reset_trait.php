<?php

namespace App\Http\Controllers\Traits;


use Illuminate\Support\Str;
use App\Models\password_reset_token;
use Illuminate\Support\Facades\Auth;


trait pass_reset_trait
{

    public function createToken()
    {
        $token = (string) Str::orderedUuid();

        $email = Auth::user()->email;

        $resetptoken = password_reset_token::where('email', $email)->first();
        if ($resetptoken) {
            $token = $resetptoken->token;
        }
        else{
            $reset_p = new password_reset_token();

            $reset_p->email = $email;
            $reset_p->token = $token;
            $reset_p->save();
        }
        session()->put('ptoken', $token);

    }
}
