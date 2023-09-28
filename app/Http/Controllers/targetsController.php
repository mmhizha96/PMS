<?php

namespace App\Http\Controllers;

use App\Models\year;
use App\Models\target;
use App\Models\target_status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class targetsController extends Controller
{
    public function setIndicator(Request $request)
    {
        $request->validate(['indicator_id' => 'required', 'description' => 'required', 'indicator' => 'required']);

        $indicator_id = $request['indicator_id'];
        $indicator = $request['indicator'];
        $description = $request['description'];

        session()->put('indicator_id', $indicator_id);
        session()->put('indicator', $indicator);
        session()->put('description', $description);

        return redirect('targets');
    }


    public function  targets()
    {


        $indicator_id = session()->get('indicator_id');

        $targets = target::where('indicator_id', $indicator_id)->orderby('target_id', 'desc')->get();;
        $targets = DB::select("SELECT
targets.*,
SUM( actuals.expenditure ) AS total_expenditure,
SUM( actuals.actual_value ) AS total_actuals
FROM
targets
LEFT JOIN actuals ON targets.target_id = actuals.target_id
WHERE
targets.indicator_id = $indicator_id
GROUP BY
targets.target_id
ORDER BY
targets.target_id DESC");
        $years = year::orderby('year_id', 'desc')->get();

        return view('admin.targets')->with([
            'targets' => $targets,
            'years' => $years

        ]);
    }

    public function store(Request $request)
    {

        $request->validate(['year_id' => 'required', 'target_description' => 'required|string', 'budget_value' => 'required', 'target_value' => 'required']);

        $indicator_id = session()->get('indicator_id');
        $department_id = session()->get('department_id');
        $target = new target();


        try {
            $target->year_id = $request->input('year_id');
            $target->target_description = $request->input('target_description');
            $target->budget_value = $request->input('budget_value');
            $target->target_value = $request->input('target_value');
            $target->indicator_id = $indicator_id;
            $target->department_id = $department_id;
            $target->baseline = $request->input('baseline');
            $target->project_vote_number = $request->input('project_vote_number');
            $target->save();
            $target_status = new target_status();
            $target_status->target_id = $target->target_id;
            $target_status->status = 1;
            $target_status->comment = "not achived";
            $target_status->save();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->back()->with([

                    'error' => 'target Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'error' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }



        $targets = target::where('indicator_id', $indicator_id)->orderby('target_id', 'desc')->get();
        return redirect()->back()->with([
            'targets' =>  $targets,
            'message' => 'targets created successfully!',
            'status' => 'success'
        ]);
    }

    public function update(Request $request)
    {


        $request->validate(['target_id' => 'required', 'project_vote_number' => 'required', 'baseline' => 'required', 'year_id' => 'required', 'target_description' => 'required|string', 'budget_value' => 'required', 'target_value' => 'required']);
        $indicator_id = session()->get('indicator_id');
        $target_id = $request['target_id'];
        $target = target::find($target_id);

        try {

            $target->year_id = $request->input('year_id');
            $target->budget_value = $request->input('budget_value');
            $target->target_value = $request->input('target_value');
            $target->baseline = $request->input('baseline');
            $target->project_vote_number = $request->input('project_vote_number');
            $target->target_description = $request->input('target_description');
            $target->update();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->back()->with([

                    'error' => 'target Already Exist',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'error' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }



        $targets = target::where('indicator_id', $indicator_id)->orderby('target_id', 'desc')->get();
        return redirect()->back()->with([
            'targets' =>  $targets,
            'message' => 'targets created successfully!',
            'status' => 'success'
        ]);
    }

    public function delete(Request $request)
    {

        $request->validate(['target_id' => 'required']);
        $indicator_id = session()->get('indicator_id');
        $target_id = $request->input('target_id');
        $target = target::find($target_id);

        try {

            $target->delete();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1451) {
                return redirect()->back()->with([

                    'error' => 'item cannot be deleted because its being used by other parts of the system',
                    'status' => 'success'
                ]);
            } else {
                return redirect()->back()->with([

                    'error' => $ex->getMessage(),
                    'status' => 'success'
                ]);
            }
        }




        $targets = target::where('indicator_id', $indicator_id)->orderby('target_id', 'desc')->get();
        return redirect()->back()->with([
            'targets' =>  $targets,
            'message' => 'targets deleted successfully!',
            'status' => 'success'
        ]);
    }
}
