<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;

use Illuminate\Database\QueryException;

class departmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['department_name' => 'required|string', 'phone' => 'required', 'extension' => 'required']);

        $department = new department();

        try {
            $department::create($request->toArray());
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->back()->with([

                    'errors' => 'department Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'errors' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }

        $departments = department::all();
        return redirect()->back()->with([
            'departments' => $departments,
            'message' => 'department added successfully!',
            'status' => 'success'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate(['department_id' => 'required']);


        $department_id = $request['department_id'];
        try {
            $department = department::find($department_id);
            $department->department_name = $request->input('department_name');
            $department->phone = $request->input('phone');
            $department->extension = $request->input('extension');
            $department->update();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->back()->with([

                    'errors' => 'department Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'errors' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }

        $departments = department::all();
        return redirect()->back()->with([
            'departments' => $departments,
            'message' => 'department updated successfully!',
            'status' => 'success'
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate(['department_id' => 'required']);
        $department_id = $request['department_id'];

        try {
            $departments =  department::find($department_id);
            $departments->delete();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1451) {
                return redirect()->back()->with([

                    'errors' => 'item cannot be deleted because its being used by other parts of the system',
                    'status' => 'success'
                ]);
            } else {
            return redirect()->back()->with([

                'errors' => $ex->getMessage(),
                'status' => 'success'
            ]);
        }
        }
        $departments = department::all();
        return redirect()->back()->with([
            'departments' => $departments,
            'message' => 'department deleted successfully!',
            'status' => 'success'
        ]);
    }
    public function getDepartments()
    {

        $departments =  department::all();

        return view('admin.departments')->with(['departments' => $departments]);
    }
}
