<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\indicator;
use App\Models\target;
use App\Models\User;
use App\Models\year;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function home()
    {
        $users = User::count();
        $departments = department::count();
        $targets = target::count();
        $indicators = indicator::count();
        $years = year::count();

        return view('admin.home')->with(
            [
                'users_total' => $users,
                'departments_total' => $departments,
                'indicators_total' => $indicators,
                'targets_total' =>  $targets,
                'years' => $years
            ]
        );
    }
}
