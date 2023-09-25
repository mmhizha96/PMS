<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\department;
use App\Models\user_role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{
    //

    public function getUsers()
    {
        $users = User::join('departments', 'departments.department_id', '=', 'users.department_id')->orderby('user_id', 'desc')->get();
        $roles = user_role::all();
        $departments =  department::all();



        return view('admin.users')->with(['users' => $users, 'roles' => $roles, 'departments' => $departments]);
    }

    public function create_User(Request $request)
    {

        $request->validate(['name' => 'required|string', 'department_id' => 'required', 'email' => 'required||unique:users', 'phone' => 'required']);
        $user = new User();
        $request['status'] = '1';
        $request['password'] = Hash::make($request['email']);
        try {
            $user::create($request->toArray());
        } catch (QueryException $ex) {
            return redirect()->back()->with([

                'errors' => $ex->getMessage(),
                'status' => 'success'
            ]);
        }
        $users = User::join('departments', 'departments.department_id', '=', 'users.department_id')->orderby('user_id', 'desc')->get();
        $roles = user_role::all();
        $departments =  department::all();
        return redirect()->back()->with([
            'users' => $users,
            'roles' => $roles,
            'departments' => $departments,
            'message' => 'user deleted successfully!',
            'status' => 'success'
        ]);
    }
}
