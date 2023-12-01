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



        return view('Admin.users')->with(['users' => $users, 'roles' => $roles, 'departments' => $departments]);
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
            toastr()->error('Oops! server error');

            return redirect()->back();
        }
        toastr()->success(' user created successfully');

        return redirect()->back();
    }


    public function update_users(Request $request)
    {
        $request->validate(['user_id' => 'required|numeric', 'name' => 'required|string', 'department_id' => 'required', 'phone' => 'required', 'role_id' => 'required|numeric']);
        try {
            $user = user::find($request['user_id']);
            $user->name = $request['name'];
            $user->role_id = $request['role_id'];
            $user->department_id = $request['department_id'];

            $user->phone = $request['phone'];
            $user->update();
        } catch (QueryException $ex) {
            toastr()->error('Oops! server error');

            return redirect()->back();
        }
        toastr()->success(' user updated successfully');

        return redirect()->back();
    }

    public function activate_deactivate(Request $request)
    {
        $request->validate(['user_id' => 'required|numeric', 'status' => 'required|numeric']);

        try {
            $user = user::find($request['user_id']);
            $user->status = ($request['status'] == 1) ? 0 : 1;
            $user->update();
        } catch (QueryException  $ex) {
            toastr()->error('Oops! server error');

            return redirect()->back();
        }
        toastr()->success(' user updated successfully');

        return redirect()->back();

    }
}
