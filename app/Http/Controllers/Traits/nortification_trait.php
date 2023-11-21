<?php

namespace App\Http\Controllers\Traits;



use App\Models\nortification;

use Illuminate\Support\Facades\Auth;


trait nortification_trait
{
    public function fetchNortification()
    {
        $user_id = Auth::user()->user_id;
        $nortifications = nortification::where('recipients', $user_id)->where('status', 0);

        session()->put("nortifications", $nortifications->get());
        session()->put("nortification_count", $nortifications->count());

        return response()->json(["count" => $nortifications->count(), "nortifications" => $nortifications->get()]);
    }
}
