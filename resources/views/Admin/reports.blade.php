@extends('layouts.app')
@section('content')
    <div class="card mt-3 ">
        <div class="card-header">
            <h3 class="card-title">YEARLY PERFOMANCE REPORTS</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0 mt-3 mr-1 ml-1">
            <table id="example1" class="table table-striped ">
                <thead>
                    <tr style="font-size: 13px">

                        <th>DEPARTMENT</th>
                        <th>KPI NO </th>
                        <th>PROJECT VOTE NUMBER</th>
                        <th>BASELINE </th>

                        <th>KPI </th>
                        <th>ANNUAL PERFOMANCE TARGET </th>
                        <th>BUDGET </th>
                        <th>KPI TYPE</th>
                        <th>YEAR</th>
                        <th>Quater </th>
                        <th>TOTAL QUARTERL PROJECTION </th>
                        <th>TOTAL EXPENDITURE</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($reportData)
                        @foreach ($reportData as $reportData)
                            <tr>
                                <td>{{ $reportData->department_name }}</td>
                                <td>{{ $reportData->kpn_number }}</td>
                                <td>{{ $reportData->project_vote_number }}</td>
                                <td>{{ $reportData->baseline }}</td>
                                <td>{{ $reportData->indicator }}</td>
                                <td>{{ $reportData->target_description }}</td>
                                <td>{{ $reportData->budget_value }}</td>
                                <td>{{ $reportData->kpi_type }}</td>
                                <td>{{ $reportData->year }}</td>
                                <td>{{ $reportData->quarter_name }}</td>
                                <td>{{ $reportData->total_actuals }}</td>
                                <td>{{ $reportData->total_expenditure }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

    </div>

@endsection
