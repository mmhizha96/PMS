<?php

namespace App\Http\Controllers;

use App\Models\quarter;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class quartersController extends Controller
{
    //
    public function setyear(Request $request)
    {
        $request->validate(['year_id' => 'required', 'year' => 'required']);
        $year_id = $request->input('year_id');
        $year = $request->input('year');

        session()->put('year_id', $year_id);
        session()->put('year', $year);

        return redirect('quarter');
    }
    public function getQuaters()
    {


        $year_id = session()->get('year_id');

        $quaters = quarter::where('year_id', $year_id)->get();

        return view('admin.quaters')->with([
            'quarters' => $quaters,

        ]);
    }


    public function  store(Request $request)
    {
        $data =   $request->validate(['quarter_name' => 'required',  'start_date' => 'required', 'end_date' => 'required']);
        $data['year_id'] =  session()->get('year_id');
        $quater = new quarter();
        $year_id = session()->get('year_id');
        try {
            $quater->create($data);
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->back()->with([

                    'errors' => 'quater Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'errors' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }
        $quaters = quarter::where('year_id', $year_id)->get();
        return redirect()->back()->with([
            'quarters' =>  $quaters,
            'message' => 'indicator created successfully!',
            'status' => 'success'
        ]);
    }
    public function  update(Request $request)
    {
        $request->validate(['quarter_name' => 'required', 'start_date' => 'required', 'end_date' => 'required', 'quarter_id' => 'required']);
        $quarter_name = $request->input('quarter_name');
        $quarter_id = $request->input('quarter_id');
        $year_id =  session()->get('year_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $quarter = quarter::find($quarter_id);

        try {
            $quarter->quarter_name = $quarter_name;
            $quarter->start_date = $start_date;
            $quarter->end_date = $end_date;
            $quarter->update();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->back()->with([

                    'errors' => 'quater Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'errors' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }
        $quaters = quarter::where('year_id', $year_id)->get();
        return redirect()->back()->with([
            'quarters' =>  $quaters,
            'message' => 'indicator updated successfully!',
            'status' => 'success'
        ]);
    }
    public function  destroy(Request $request)
    {
        $request->validate(['quarter_id' => 'required']);
        $quarter_id = $request->input('quarter_id');
        $year_id =  session()->get('year_id');
        $quarter = quarter::find($quarter_id);
        try {
            $quarter->delete();
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

        $quaters = quarter::where('year_id', $year_id)->get();
        return redirect()->back()->with([
            'quarters' =>  $quaters,
            'message' => 'indicator deleted successfully!',
            'status' => 'success'
        ]);
    }
}
