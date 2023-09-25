<?php

namespace App\Http\Controllers;

use App\Models\year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reportsController extends Controller
{
    public function getReportData()
    {

        $year_id =  year::max('year_id');

        $years = year::orderby('year_id', 'desc')->get();

        $yearly_report = DB::select("SELECT departments.department_name, indicators.indicator, indicators.description,targets.budget_value,
targets.baseline, targets.project_vote_number, targets.target_value, targets.target_description,indicators.kpi_type,indicators.kpn_number, SUM( actuals.expenditure ) AS total_expenditure,
 SUM( actuals.actual_value ) AS total_actuals, years.`year`,
	quarters.quarter_name FROM departments INNER JOIN indicators ON departments.department_id = indicators.department_id INNER JOIN
targets ON indicators.indicator_id = targets.indicator_id INNER JOIN years ON targets.year_id = years.year_id INNER JOIN quarters ON
 years.year_id = quarters.year_id LEFT JOIN actuals ON targets.target_id = actuals.target_id AND quarters.quarter_id = actuals.quarter_id WHERE
  targets.year_id = $year_id GROUP BY actuals.quarter_id");

        // var_dump($yearly_report);
        // die();
        return view('admin.reports')->with([
            'reportData' => $yearly_report,
            'years' => $years

        ]);
    }
}
