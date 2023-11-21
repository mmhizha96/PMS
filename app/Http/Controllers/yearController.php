<?php

namespace App\Http\Controllers;

use App\Models\year;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class yearController extends Controller
{
    //

    public function getYears()
    {
        $years = year::all();
        return view('admin.years')->with(['years' => $years]);
    }



    public function store(Request $request)
    {
        $request->validate(['year' => 'required']);
        $year = new year();
        // dd($request);
        try {
            $year::create($request->toArray());
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                toastr()->error('Oops! year already exists');

                return redirect()->back();
            } else {
                toastr()->error('Oops! server error');

                return redirect()->back();
            }
        }
        toastr()->success('year created successfully');

        return redirect()->back();
    }
    public function destroy(Request $request)
    {

        $request->validate(['year_id' => 'required']);
        $year_id = $request['year_id'];

        $year = year::find($year_id);
        try {
            $year->delete();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1451) {

                toastr()->error('year cannot be deleted');

                return redirect()->back();
            } else {
                toastr()->error('Oops! server error');

                return redirect()->back();
            }
        }

        toastr()->success('year deleted successfully');

        return redirect()->back();
    }


    public function activate_deactivate(Request $request)
    {
        $request->validate(['year_id' => 'required|numeric', 'status' => 'required|numeric']);

        $year = year::find($request['year_id']);

        // when user want to activate deactivate any active year
        if ($request['status'] == 1) {
            $year_active = year::where('status', 1)->first();
            if ($year_active) {
                toastr()->error("Ooops! there is another active year please deactivate it first");
                return redirect()->back();
            }
        }
        $year->status = $request['status'];
        $year->update();

        toastr()->success("update successful");
        return redirect()->back();
    }
}
