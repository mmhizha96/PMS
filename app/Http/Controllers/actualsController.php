<?php

namespace App\Http\Controllers;

use App\Models\actual;
use App\Models\target;
use App\Models\quarter;
use App\Models\target_status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class actualsController extends Controller
{
    public function setTarget(Request $request)
    {
        $request->validate(['target_id' => 'required', 'target_description' => 'required', 'year_id' => 'required', 'department_id' => 'required']);

        $target_id = $request['target_id'];
        $target_description = $request['target_description'];
        $target = $request['target'];
        $year_id = $request['year_id'];
        $department_id = $request['department_id'];

        session()->put('target_id', $target_id);
        session()->put('target_description', $target_description);
        session()->put('year_id', $year_id);
        session()->put('department_id', $department_id);
        return redirect('actuals');
    }

    public function  actuals()
    {


        $target_id = session()->get('target_id');
        $year_id = session()->get('year_id');

        $actuals = actual::join('targets', 'targets.target_id', '=', 'actuals.target_id')->join('quarters', 'quarters.quarter_id', '=', 'actuals.quarter_id')->where('actuals.target_id', $target_id)
            ->orderby('actual_id', 'desc')->get();
        $quaters = quarter::where('year_id', $year_id)->get();



        return view('admin.actuals')->with([
            'actuals' => $actuals,
            'quarters' => $quaters

        ]);
    }

    public function store(Request $request)
    {

        $request->validate(['file' => 'required|mimes:pdf,xlx,csv,doc|max:2048', 'expenditure' => 'required', 'quarter_id' => 'required', 'actual_value' => 'required', 'actual_description' => 'required']);

        $target_id = session()->get('target_id');
        $year_id = session()->get('year_id');
        $department_id =     session()->get('department_id');
        $user =     Auth::user()->email;



        $actual = new actual();
        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('uploads'), $fileName);


        try {

            // update target status
            if ($request['is_final']) {

                $target_totals = DB::select("SELECT
          SUM( actuals.actual_value ) AS total_actuals,
          targets.target_value
      FROM
          targets
          INNER JOIN actuals ON targets.target_id = actuals.target_id
      WHERE
          actuals.target_id = $target_id");

                $status = 0;
                $reason_for_deviation = $request['reason_for_deviation'];
                $comment = "not achieved";
                $total_actuals = 0;
                $target = target::find($target_id);
                $target_value = $target->target_value;

                if ($target_totals[0]) {

                    $total_actuals = $target_totals[0]->total_actuals + $request->input('actual_value');
                }

                if ($total_actuals == $target_value) {
                    $comment == "achieved";
                    $reason_for_deviation = "";
                } else if ($total_actuals > $target_value) {
                    $comment = "exceeded";
                    $reason_for_deviation = "";
                } else if ($total_actuals < $target_value) {
                  
                    if ($request['reason_for_deviation'] == null) {
                        return redirect()->back()->with([

                            'errors' => 'reason for deviation is required',
                            'status' => 'success'
                        ]);
                    }
                }


                $target_status =  target_status::where('target_id', $target_id)->first();

                $target_status->comment = $comment;
                $target_status->status_code = $status;
                $target_status->reason_for_deviation = $reason_for_deviation;
                $target_status->update();
            }

            $actual->actual_description = $request->input('actual_description');
            $actual->document_path = $fileName;
            $actual->actual_value = $request->input('actual_value');
            $actual->expenditure = $request->input('expenditure');
            $actual->quarter_id = $request->input('quarter_id');
            $actual->department_id = $department_id;
            $actual->target_id = $target_id;
            $actual->year_id = $year_id;
            $actual->created_by = $user;
            $actual->save();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->back()->with([

                    'errors' => 'actual Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'errors' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }


        $actuals = actual::join('targets', 'targets.target_id', '=', 'actuals.target_id')->join('quarters', 'quarters.quarter_id', '=', 'actuals.quarter_id')->where('actuals.target_id', $target_id)
            ->orderby('actual_id', 'desc')->get();
        $quaters = quarter::where('year_id', $year_id)->get();

        return redirect()->back()->with([
            'actuals' => $actuals,
            'quarters' => $quaters,
            'message' => 'actuals uploaded successfully!',
            'status' => 'success'
        ]);
    }



    public function delete(Request $request)
    {

        $request->validate(['actual_id' => 'required']);
        $actual_id = $request['actual_id'];
        $actual = actual::find($actual_id);

        $target_id = session()->get('target_id');
        $year_id = session()->get('year_id');

        try {
            unlink('uploads/' . $actual->document_path);
            $actual->delete();
        } catch (QueryException $ex) {

            return redirect()->back()->with([

                'errors' => $ex->getMessage(),
                'status' => 'success'
            ]);
        }




        $actuals = actual::join('targets', 'targets.target_id', '=', 'actuals.target_id')->join('quarters', 'quarters.quarter_id', '=', 'actuals.quarter_id')->where('actuals.target_id', $target_id)
            ->orderby('actual_id', 'desc')->get();
        $quaters = quarter::where('year_id', $year_id)->get();

        return redirect()->back()->with([
            'actuals' => $actuals,
            'message' => 'actuals uploaded successfully!',
            'status' => 'success'
        ]);
    }
}
