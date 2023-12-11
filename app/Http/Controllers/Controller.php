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


}
