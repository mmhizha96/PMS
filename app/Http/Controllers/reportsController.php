<?php

namespace App\Http\Controllers;

use App\Models\year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reportsController extends Controller
{
    public function getQuarterlyReportData()
    {

        $year_id = (session()->get('filteryear_id') != null) ? session()->get('filteryear_id') :  year::max('year_id');

        $years = year::orderby('year_id', 'desc')->get();

        $yearly_report = DB::select("SELECT
        pms.departments.department_name,
        pms.indicators.indicator,
        pms.indicators.description,
        pms.targets.budget_value,
        pms.targets.baseline,
        pms.targets.project_vote_number,
        pms.targets.target_value,
        pms.targets.target_description,
        pms.indicators.kpi_type,
        pms.indicators.kpn_number,
        SUM( pms.actuals.expenditure ) AS total_expenditure,
        SUM( pms.actuals.actual_value ) AS total_actuals,
        pms.years.`year`,
        pms.quarters.quarter_name
    FROM
        pms.departments
        INNER JOIN pms.indicators ON pms.departments.department_id = pms.indicators.department_id
        INNER JOIN pms.targets ON pms.indicators.indicator_id = pms.targets.indicator_id
        INNER JOIN pms.quarters ON pms.targets.year_id = pms.quarters.year_id
        LEFT JOIN pms.actuals ON pms.quarters.quarter_id = pms.actuals.quarter_id
        AND pms.targets.target_id = pms.actuals.target_id
        INNER JOIN pms.years ON pms.targets.year_id = pms.years.year_id
    WHERE
        pms.targets.year_id = $year_id
    GROUP BY
        pms.quarters.quarter_id,
        pms.targets.target_id,
        pms.departments.department_id,
        pms.indicators.indicator_id");
        session()->remove('filteryear_id');
        return view('admin.reports')->with([
            'reportData' => $yearly_report,
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

        $yearly_report = DB::select("SELECT
        SUM( actuals.actual_value ) AS total_actuals,
        actuals.expenditure AS total_expenditure,
        departments.department_name,
        indicators.indicator,
        targets.budget_value,
        targets.baseline,
        targets.project_vote_number,
        targets.target_value,
        target_statuses.reason_for_deviation,
        target_status_codes.`status`,
        target_statuses.`comment`,
        indicators.kpn_number,
        targets.target_description,
        indicators.kpi_type,
        years.`year`
    FROM
        departments
        INNER JOIN indicators ON departments.department_id = indicators.department_id
        INNER JOIN targets ON indicators.indicator_id = targets.indicator_id
        INNER JOIN actuals ON targets.target_id = actuals.target_id
        INNER JOIN target_statuses ON targets.target_id = target_statuses.target_id
        INNER JOIN target_status_codes ON target_statuses.status_code = target_status_codes.status_code
        INNER JOIN years ON targets.year_id = years.year_id
    WHERE
        targets.year_id = $year_id
    GROUP BY
        departments.department_id,
        indicators.indicator_id,
        targets.target_id");
        session()->remove('filteryear_id');
        return view('admin.yearlyreport')->with([
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
