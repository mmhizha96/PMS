<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Traits;

class departmentController extends Controller
{
    use Traits\nortification_trait;
    public function store(Request $request)
    {

        $request->validate(['department_name' => 'required|string', 'phone' => 'required', 'extension' => 'required']);

        $department = new department();

        try {
            $department::create($request->toArray());
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                toastr()->error('Ooops! department already exists!');

                return redirect()->back();
            } else {
                toastr()->error('Ooops! error occured!');

                return redirect()->back();
            }
        }

        toastr()->success(' successfully created!');

        return redirect()->back();
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
                toastr()->error('Ooops! department already exists!');

                return redirect()->back();
            } else {
                toastr()->error('Ooops! error occured!');

                return redirect()->back();
            }
        }
        toastr()->success(' successfully updated!');

        return redirect()->back();
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
                toastr()->error('Ooops! item cannot be deleted because its being used by other parts of the system!');

                return redirect()->back();
            } else {
                toastr()->error('Ooops! error occured!');

                return redirect()->back();
            }
        }
        toastr()->success(' successfully deleted!');

        return redirect()->back();
    }
    public function getDepartments()
    {

        $departments =  department::all();

        return view('Admin.departments')->with(['departments' => $departments]);
    }
}
