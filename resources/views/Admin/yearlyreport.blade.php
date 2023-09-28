@extends('layouts.app')
@section('content')
    <div class="card mt-3 ">
        <div class="card-header">
            <h3 class="card-title">QUARTERLY PERFOMANCE REPORTS</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0 mt-3 mr-1 ml-1">
            <form action="{{ route('filteryearreport') }}" method="post">
                @csrf
                <div class="row p-3">
                    <div class="col-md-4">

                        <div class="input-group mb-3">

                            <select class="form-control" name="year_id" required>
                                <option value="">filter by year</option>
                                @isset($years)
                                    @foreach ($years as $year)
                                        <option value="{{ $year->year_id }}">{{ $year->year }}</option>
                                    @endforeach
                                @endisset



                            </select>
                            <button type="submit" class="input-group-append btn bg-primary2">filter</button>
                        </div>


                    </div>

                </div>

            </form>
            <table id="example2" class="table table-striped ">
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

                        <th>TOTAL QUARTERL PROJECTION </th>
                        <th>TOTAL EXPENDITURE</th>
                        <th> PROGRESS</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($reportData)
                        @foreach ($reportData as $reportData)
                            <tr>
                                <td>{{ $reportData->department_name }}</td>
                                <td>{{ $reportData->kpn_number }}</td>
                                <td>{{ $reportData->project_vote_number }}</td>
                                <td>{{ $reportData->baseline }}</td>
                                <td>{{ $reportData->indicator }}</td>
                                <td>{{ $reportData->target_description }}</td>
                                <td>
                                    @if ($reportData->budget_value == 0)
                                        OPEX
                                    @else
                                        {{ $reportData->budget_value }}
                                    @endif
                                </td>
                                <td>{{ $reportData->kpi_type }}</td>
                                <td>{{ $reportData->year }}</td>

                                <td>{{ $reportData->total_actuals }}</td>
                                <td>{{ $reportData->total_expenditure }}</td>
                                <td>{{ $reportData->status }}</td>
                                <td>{{ $reportData->comment }}</td>
                            </tr>
                        @endforeach
                    @endisset


                </tbody>
            </table>


         

        </div>
        <!-- /.card-body -->

    </div>

@endsection


