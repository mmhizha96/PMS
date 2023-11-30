<?php

namespace App\Http\Controllers;

use App\Models\year;
use App\Models\target;
use App\Models\indicator;
use App\Models\department;
use Illuminate\Http\Request;
use App\Models\target_status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        session()->put('can_create', true);
        $request->session()->forget('indicators');
        return redirect('targets');
    }
    public function setMyIndicator()
    {
        session()->put('indicator_id', 'all');
        session()->put('can_create', false);
        session()->forget('indicator');
        return redirect('targets');
    }

    public function  targets()
    {


        $indicator_id = session()->get('indicator_id');
        $indicators = indicator::orderby('indicator_id', 'desc')->get();
        $departments = department::orderby('department_id', 'desc')->get();
        $years = year::orderby('year_id', 'desc')->get();
        $targets = "";
        $yearactive = year::where('status', 1)->first();
        if ($yearactive) {
            $year_id = $yearactive->year_id;
            if (Auth::user()->role_id == 1) {

                if ($indicator_id == 'all') {

                    $targets = DB::select("SELECT
        targets.*,
        SUM( actuals.expenditure ) AS total_expenditure,
        SUM( actuals.actual_value ) AS total_actuals,
        target_status_codes.`status`,
        target_status_codes.status_code,
        years.year,
        departments.department_name
    FROM
        targets
        LEFT JOIN actuals ON targets.target_id = actuals.target_id
        INNER JOIN target_statuses ON targets.target_id = target_statuses.target_id
        INNER JOIN target_status_codes ON target_statuses.status_code = target_status_codes.status_code
        INNER JOIN
years
ON
targets.year_id = years.year_id
INNER JOIN
departments
ON
targets.department_id = departments.department_id

where targets.year_id=$year_id
    GROUP BY
        targets.target_id
    ORDER BY
        targets.target_id DESC");
                } else {

                    $targets = DB::select("SELECT
targets.*,
SUM( actuals.expenditure ) AS total_expenditure,
SUM( actuals.actual_value ) AS total_actuals,
target_status_codes.`status`,
target_status_codes.status_code
,        years.year,
        departments.department_name
FROM
targets
LEFT JOIN actuals ON targets.target_id = actuals.target_id
INNER JOIN target_statuses ON targets.target_id = target_statuses.target_id
INNER JOIN target_status_codes ON target_statuses.status_code = target_status_codes.status_code
INNER JOIN
years
ON
targets.year_id = years.year_id
INNER JOIN
departments
ON
targets.department_id = departments.department_id
WHERE
targets.indicator_id = $indicator_id
AND   targets.year_id=$year_id
GROUP BY
targets.target_id
ORDER BY
targets.target_id DESC
");
                }
            } else {
                if ($indicator_id == 'all') {

                    $department_id = Auth::user()->department_id;

                    $targets = DB::select("SELECT
        targets.*,
        SUM( actuals.expenditure ) AS total_expenditure,
        SUM( actuals.actual_value ) AS total_actuals,
        target_status_codes.`status`,
        target_status_codes.status_code
        ,        years.year,
        departments.department_name
    FROM
        targets
        LEFT JOIN actuals ON targets.target_id = actuals.target_id
        INNER JOIN target_statuses ON targets.target_id = target_statuses.target_id
        INNER JOIN target_status_codes ON target_statuses.status_code = target_status_codes.status_code
        INNER JOIN
years
ON
targets.year_id = years.year_id
INNER JOIN
departments
ON
targets.department_id = departments.department_id
    WHERE
        targets.department_id = $department_id AND targets.year_id=$year_id
    GROUP BY
        targets.target_id
    ORDER BY
        targets.target_id DESC");
                } else {

                    $targets = DB::select("SELECT
targets.*,
SUM( actuals.expenditure ) AS total_expenditure,
SUM( actuals.actual_value ) AS total_actuals,
target_status_codes.`status`,
target_status_codes.status_code
,        years.year,
        departments.department_name
FROM
targets
LEFT JOIN actuals ON targets.target_id = actuals.target_id
INNER JOIN target_statuses ON targets.target_id = target_statuses.target_id
INNER JOIN target_status_codes ON target_statuses.status_code = target_status_codes.status_code
INNER JOIN
years
ON
targets.year_id = years.year_id
INNER JOIN
departments
ON
targets.department_id = departments.department_id
WHERE
targets.indicator_id = $indicator_id and targets.year_id=$year_id
GROUP BY
targets.target_id
ORDER BY
targets.target_id DESC
");
                }
            }
        } else {
            toastr()->error("there is no active year set ");

        }







        return view('admin.targets')->with([
            'targets' => $targets,
            'indicators' => $indicators,
            'departments' => $departments,
            'years' => $years

        ]);
    }

    public function store(Request $request)
    {

        $request->validate(['year_id' => 'required', 'indicator_id' => 'required', 'department_id' => 'required', 'target_description' => 'required|string', 'budget_value' => 'required', 'target_value' => 'required']);

        $indicator_id = $request->input('indicator_id');
        $department_id = $request->input('department_id');
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
            $target_status->status_code = 1;
            $target_status->save();
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {

                toastr()->error('Oops! target Already Exist');

                return redirect()->back();
            } else {
                toastr()->error('Oops! server error!');

                return redirect()->back();
            }
        }




        toastr()->success(' successfully created!');

        return redirect()->back();
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

                toastr()->error('Oops! target Already Exist');

                return redirect()->back();
            } else {
                toastr()->error('Oops! server error');

                return redirect()->back();
            }
        }


        toastr()->success(' targets created successfully!');

        return redirect()->back();
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
                toastr()->error('Oops! item cannot be deleted because its being used by other parts of the system');

                return redirect()->back();
            } else {
                toastr()->error('Oops! server error');

                return redirect()->back();
            }
        }



        toastr()->success(' targets deleted successfully!');

        return redirect()->back();
    }


    public function markAsComplete(Request $request)
    {

        $request->validate(['target_id' => 'required|numeric', 'target_value' => 'required', 'total_actuals' => 'required']);
        $target_id = $request['target_id'];
        $total_actuals = $request['total_actuals'];
        $target_value = $request['target_value'];


        if ($total_actuals < $target_value) {
            $request->validate(["reason_for_deviation" => 'required', 'correctrive_action' => 'required']);
        }
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
        $corrective_action = $request['correctrive_action'];
        $total_actuals = 0;
        $target = target::find($target_id);
        $target_value = $target->target_value;

        if ($target_totals[0]) {

            $total_actuals = $target_totals[0]->total_actuals + $request->input('actual_value');
        } else if ($total_actuals < $target_value) {

            if ($request['reason_for_deviation'] == null) {
                toastr()->error('Oops! reason for deviation is required');

                return redirect()->back();
            }
        }


        try {
            $target_status =  target_status::where('target_id', $target_id)->first();
            $target->corrective_action = $corrective_action;

            $target_status->status_code = $status;
            $target_status->reason_for_deviation = $reason_for_deviation;
            $target_status->update();
        } catch (QueryException $ex) {
            toastr()->error('Oops! server error');

            return redirect()->back();
        }

        toastr()->success(' targets deleted successfully!');

        return redirect()->back();
    }
}
