<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\year;
use App\Models\target;
use App\Models\indicator;
use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        SUM( actuals.actual_value ) AS total_actuals,
        indicators.indicator
    FROM
        indicators
        INNER JOIN targets ON indicators.indicator_id = targets.indicator_id
        left JOIN actuals ON targets.target_id = actuals.target_id
    WHERE
        targets.year_id = $year_id
    GROUP BY
        targets.target_id,
        indicators.indicator_id");
        $pie_report_data = DB::select("SELECT
COUNT(*) AS total,
target_statuses.`comment`
FROM
targets
INNER JOIN
target_statuses
ON
    targets.target_id = target_statuses.target_id
INNER JOIN
target_status_codes
ON
    target_statuses.status_code = target_status_codes.status_code
WHERE
targets.year_id = $year_id
GROUP BY
target_statuses.`comment`");


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
}
