<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\year;
use App\Models\target;
use App\Models\indicator;
use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function home()
    {
        $users = User::count();
        $departments = department::count();
        $targets = target::count();
        $indicators = indicator::count();
        $years = year::count();
        $year_id = (session()->get('filteryear_id') != null) ? session()->get('filteryear_id') :  year::max('year_id');


        $targets_reports_bachart = DB::select("SELECT
        targets.target_value,
        SUM(actuals.actual_value) AS total_actuals,
        indicators.indicator,
        targets.target_summary,
        departments.department_name,
        departments.department_id
    FROM
        indicators
        INNER JOIN
        targets
        ON
            indicators.indicator_id = targets.indicator_id
        LEFT JOIN
        actuals
        ON
            targets.target_id = actuals.target_id
        INNER JOIN
        departments
        ON
            indicators.department_id = departments.department_id
    WHERE
        targets.year_id = $year_id
    GROUP BY
        targets.target_id,
        indicators.indicator_id");



        $pie_report_data = DB::select("SELECT
	targets.target_value,
	SUM( actuals.actual_value ) AS total_actuals,
	targets.target_id
FROM
	targets
	INNER JOIN target_statuses ON targets.target_id = target_statuses.target_id
	INNER JOIN target_status_codes ON target_statuses.status_code = target_status_codes.status_code
	INNER JOIN actuals ON targets.target_id = actuals.target_id
WHERE
	targets.year_id = $year_id
	");


        return view('admin.home')->with(
            [
                'users_total' => $users,
                'departments_total' => $departments,
                'indicators_total' => $indicators,
                'targets_total' =>  $targets,
                'years' => $years,
                'piereportData' => $pie_report_data,
                'target_reports' => $targets_reports_bachart
            ]
        );
    }


    public function userhome()
    {

        $department_id = Auth::user()->department_id;
        $year_id = (session()->get('filteryear_id') != null) ? session()->get('filteryear_id') :  year::max('year_id');
        $targets = target::where('department_id', $department_id)->where('year_id', $year_id)->count();
        $indicators = indicator::join('targets', 'targets.indicator_id', '=', 'indicators.indicator_id')->where('year_id', $year_id)->where('indicators.department_id', $department_id)->count();

        $userdepartment = department::find($department_id);

        session()->put('department', $userdepartment);

        $targets_reports_bachart = DB::select("SELECT
        targets.target_value,
        SUM( actuals.actual_value ) AS total_actuals,
        indicators.indicator,
        targets.target_summary
    FROM
        indicators
        INNER JOIN targets ON indicators.indicator_id = targets.indicator_id
        LEFT JOIN actuals ON targets.target_id = actuals.target_id
    WHERE
        targets.year_id = $year_id
        AND targets.department_id = $department_id
    GROUP BY
        targets.target_id,
        indicators.indicator_id");

        $pie_report_data = DB::select("
        SELECT
	targets.target_value,
	SUM( actuals.actual_value ) AS total_actuals,
	targets.target_id,
    targets.target_summary
FROM
	targets
	INNER JOIN target_statuses ON targets.target_id = target_statuses.target_id
	INNER JOIN target_status_codes ON target_statuses.status_code = target_status_codes.status_code
	INNER JOIN actuals ON targets.target_id = actuals.target_id
WHERE
	targets.year_id = $year_id
	AND targets.department_id = $department_id
    ");


        return view('user.userhome')->with(
            [

                'indicators_total' => $indicators,
                'targets_total' =>  $targets,
                'piereportData' => $pie_report_data,
                'target_reports' => $targets_reports_bachart
            ]
        );
    }
}
