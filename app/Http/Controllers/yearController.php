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
                return redirect()->back()->with([

                    'errors' => 'year Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'errors' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }
        $years = year::all();
        return redirect()->back()->with([
            'years' => $years,
            'message' => 'year created successfully!',
            'status' => 'success'
        ]);
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
                return redirect()->back()->with([

                    'errors' => 'year cannot be deleted',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'errors' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }

        $years = year::all();
        return redirect()->back()->with([
            'years' => $years,
            'message' => 'year deleted successfully!',
            'status' => 'success'
        ]);
    }
}
