<?php

namespace App\Http\Controllers;

use App\Models\actual;
use App\Models\target;
use App\Models\quarter;
use App\Models\rejected_actual;
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

    public function  actualsToApprove()
    {



        $user = Auth::user();
        $department_id = $user->department_id;

        $actuals = DB::select("SELECT
        actuals.actual_id,
        actuals.actual_value,
        actuals.expenditure,
        actuals.created_at,
        actuals.created_by,
        actuals.document_path,
        actuals.actual_description,
        target_statuses.status_code,
        quarters.quarter_name,
        years.`year`
    FROM
        targets
        INNER JOIN actuals ON targets.target_id = actuals.target_id
        INNER JOIN target_statuses ON targets.target_id <> target_statuses.target_id
        INNER JOIN quarters ON actuals.quarter_id = quarters.quarter_id
        INNER JOIN years ON quarters.year_id = years.year_id
    WHERE
        targets.department_id = $department_id
        AND target_statuses.status_code <> 0
    ORDER BY
        actuals.actual_id DESC");





        return view('user.approveActual')->with([
            'actuals' => $actuals


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



            $actual->actual_description = $request->input('actual_description');
            $actual->document_path = $fileName;
            $actual->actual_value = $request->input('actual_value');
            $actual->expenditure = $request->input('expenditure');
            $actual->quarter_id = $request->input('quarter_id');
            $actual->department_id = $department_id;
            $actual->target_id = $target_id;
            $actual->status = 0;
            $actual->approved_by = 'none';
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

    public function approve_reject(Request $request)
    {
        $request->validate(['actual_id' => 'required|numeric', 'status' => 'required|numeric']);
        $actual_id = $request['actual_id'];
        $status = $request['status'];
        $user_email = Auth::user()->email;

        if ($status == 2) {
            $request->validate(['reason_for_rejection' => 'required|string']);

            $rejected_actual = new rejected_actual();
            $rejected_actual->reason = $request['reason_for_rejection'];
            $rejected_actual->actual_id = $actual_id;
            $rejected_actual->rejected_by = $user_email;
            $rejected_actual->save();
        }
        $actual = actual::find($actual_id);

        $actual->status = $status;
        $actual->approved_by = $user_email;
        $actual->updated();

        return redirect()->back();
    }
}
