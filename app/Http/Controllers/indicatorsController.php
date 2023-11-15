<?php

namespace App\Http\Controllers;


use App\Models\indicator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class indicatorsController extends Controller
{

    public function setDepartment(Request $request)
    {

        $request->validate(['department_id' => 'required', 'department_name' => 'required']);
        $department_id = $request['department_id'];
        $department_name = $request['department_name'];
        session()->put('department_id', $department_id);
        session()->put('department_name', $department_name);


        return redirect('indicators');
    }
    public function setmydepartment()
    {
        return redirect('indicators');
    }

    public function getIndicators()
    {
    
        $department_id = (Auth::user()->role_id == 1) ? session()->get('department_id') : Auth::user()->department_id;

        $indicators = indicator::where('department_id', $department_id)->get();

        return view('admin.indicators')->with([
            'indicators' => $indicators,
            'department_id' => $department_id
        ]);
    }

    public function store(Request $request)
    {


        $request->validate(['indicator' => 'required', 'description' => 'required',]);
        $department_id = session()->get('department_id');
        $kpn_number = indicator::count();
        $request['kpn_number'] = $kpn_number + 1;

        $indicator = new indicator();

        try {
            $indicator::create($request->toArray());
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->back()->with([

                    'errors' => 'indicator Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'errors' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }



        $indicators = $indicator = indicator::where('department_id', $department_id)->get();
        return redirect()->back()->with([
            'indicators' => $indicators,
            'message' => 'indicator created successfully!',
            'status' => 'success'
        ]);
    }

    public function update(Request $request)
    {


        // $request->validate(['indicator' => 'required', 'description' => 'required', 'indicator_id' => 'required']);
        $department_id = session()->get('department_id');
        $indicator_id = $request['indicator_id'];
        $indicator = indicator::find($indicator_id);

        try {
            $indicator->indicator = $request->input('indicator');
            $indicator->description = $request->input('description');
            $indicator->update();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->back()->with([

                    'errors' => 'indicator Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'errors' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }



        $indicators = $indicator = indicator::where('department_id', $department_id)->get();
        return redirect()->back()->with([
            'indicators' => $indicators,
            'message' => 'indicator updated successfully!',
            'status' => 'success'
        ]);
    }

    public function delete(Request $request)
    {

        $request->validate(['indicator_id' => 'required']);
        $department_id = session()->get('department_id');
        $indicator_id = $request['indicator_id'];
        $indicator = indicator::find($indicator_id);

        try {

            $indicator->delete();
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


        $indicators = $indicator = indicator::where('department_id', $department_id)->get();
        return redirect()->back()->with([
            'indicators' => $indicators,
            'message' => 'indicator deleted successfully!',
            'status' => 'success'
        ]);
    }
}