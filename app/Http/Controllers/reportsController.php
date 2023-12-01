<?php

namespace App\Http\Controllers;

use App\Models\year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class reportsController extends Controller
{
    public function getQuarterlyReportData()
    {

        $year_id = (session()->get('filteryear_id') != null) ? session()->get('filteryear_id') :  year::max('year_id');

        $years = year::orderby('year_id', 'desc')->get();

        $user = Auth::user();
        $department_id = $user->department_id;
        if ($user->role_id == 1) {

            $quater_report = DB::select("SELECT
            departments.department_name,
            indicators.indicator,
            indicators.description,
            targets.budget_value,
            targets.baseline,
            targets.project_vote_number,
            targets.target_value,
            targets.target_description,
            indicators.kpi_type,
            indicators.kpn_number,
            SUM(actuals.expenditure) AS total_expenditure,
            SUM(actuals.actual_value) AS total_actuals,
            years.`year`,
            quarters.quarter_name
        FROM
            departments
            INNER JOIN
            indicators
            ON
                departments.department_id = indicators.department_id
            INNER JOIN
            targets
            ON
                indicators.indicator_id = targets.indicator_id
            INNER JOIN
            quarters
            ON
                targets.year_id = quarters.year_id
            LEFT JOIN
            actuals
            ON
                quarters.quarter_id = actuals.quarter_id AND
                targets.target_id = actuals.target_id
            INNER JOIN
            years
            ON
                targets.year_id = years.year_id
        WHERE
            targets.year_id = $year_id AND
            actuals.`status` = 1
        GROUP BY
            quarters.quarter_id,
            targets.target_id,
            departments.department_id,
            indicators.indicator_id");
        } else {
            $quater_report = DB::select("SELECT
            departments.department_name,
            indicators.indicator,
            indicators.description,
            targets.budget_value,
            targets.baseline,
            targets.project_vote_number,
            targets.target_value,
            targets.target_description,
            indicators.kpi_type,
            indicators.kpn_number,
            SUM(actuals.expenditure) AS total_expenditure,
            SUM(actuals.actual_value) AS total_actuals,
            years.`year`,
            quarters.quarter_name
        FROM
            departments
            INNER JOIN
            indicators
            ON
                departments.department_id = indicators.department_id
            INNER JOIN
            targets
            ON
                indicators.indicator_id = targets.indicator_id
            INNER JOIN
            quarters
            ON
                targets.year_id = quarters.year_id
            LEFT JOIN
            actuals
            ON
                quarters.quarter_id = actuals.quarter_id AND
                targets.target_id = actuals.target_id
            INNER JOIN
            years
            ON
                targets.year_id = years.year_id
        WHERE
            targets.year_id = $year_id AND
            departments.department_id = $department_id AND
            actuals.`status` = 1
        GROUP BY
            quarters.quarter_id,
            targets.target_id,
            departments.department_id,
            indicators.indicator_id");
        }
        session()->remove('filteryear_id');
        return view('Admin.reports')->with([
            'reportData' =>   $quater_report,
            'years' => $years

        ]);
    }

    public function filterQuarterlyReportData(Request $request)
    {

        $year_id =  $request->input('year_id');

        session()->put("filteryear_id", $year_id);


        return redirect()->route('quarter_report');
    }


    public function getYearlyReportData()
    {

        $year_id = (session()->get('filteryear_id') != null) ? session()->get('filteryear_id') :  year::max('year_id');

        $years = year::orderby('year_id', 'desc')->get();
        $user = Auth::user();
        $department_id = $user->department_id;


        if ($user->role_id == 1) {
            $yearly_report = DB::select("SELECT
            SUM(actuals.actual_value) AS total_actuals,
            actuals.expenditure AS total_expenditure,
            departments.department_name,
            indicators.indicator,
            targets.budget_value,
            targets.baseline,
            targets.project_vote_number,
            targets.target_value,
            target_statuses.reason_for_deviation,
            target_status_codes.`status`,
            indicators.kpn_number,
            targets.target_description,
            indicators.kpi_type,
            years.`year`
        FROM
            departments
            INNER JOIN
            indicators
            ON
                departments.department_id = indicators.department_id
            INNER JOIN
            targets
            ON
                indicators.indicator_id = targets.indicator_id
            INNER JOIN
            actuals
            ON
                targets.target_id = actuals.target_id
            INNER JOIN
            target_statuses
            ON
                targets.target_id = target_statuses.target_id
            INNER JOIN
            target_status_codes
            ON
                target_statuses.status_code = target_status_codes.status_code
            INNER JOIN
            years
            ON
                targets.year_id = years.year_id
        WHERE
            targets.year_id = $year_id AND
            actuals.`status` = 1 = 1
        GROUP BY
            departments.department_id,
            indicators.indicator_id,
            targets.target_id");
        } else {


            $yearly_report = DB::select("SELECT
	SUM(actuals.actual_value) AS total_actuals,
	actuals.expenditure AS total_expenditure,
	departments.department_name,
	indicators.indicator,
	targets.budget_value,
	targets.baseline,
	targets.project_vote_number,
	targets.target_value,
	target_statuses.reason_for_deviation,
	target_status_codes.`status`,
	indicators.kpn_number,
	targets.target_description,
	indicators.kpi_type,
	years.`year`
FROM
	departments
	INNER JOIN
	indicators
	ON
		departments.department_id = indicators.department_id
	INNER JOIN
	targets
	ON
		indicators.indicator_id = targets.indicator_id
	INNER JOIN
	actuals
	ON
		targets.target_id = actuals.target_id
	INNER JOIN
	target_statuses
	ON
		targets.target_id = target_statuses.target_id
	INNER JOIN
	target_status_codes
	ON
		target_statuses.status_code = target_status_codes.status_code
	INNER JOIN
	years
	ON
		targets.year_id = years.year_id
WHERE
	targets.year_id = $year_id AND
	departments.department_id = $department_id and
    actuals.`status` = 1
GROUP BY
	departments.department_id,
	indicators.indicator_id,
	targets.target_id");
        }

        session()->remove('filteryear_id');
        return view('Admin.yearlyreport')->with([
            'reportData' => $yearly_report,
            'years' => $years

        ]);
    }

    public function filterYearlyReportData(Request $request)
    {

        $year_id =  $request->input('year_id');

        session()->put("filteryear_id", $year_id);


        return redirect()->route('year_report');
    }
}
