@extends('layouts.app')
@section('content')
    <div class="row mt-2">

        <div class="col-md-12 container">
            @if (session('message'))
                <div class="row" id="success" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
                    x-transition:leave.duration.3000ms>
                    <div class="col-md-12">
                        <div class="alert bg-primary1 text-white" role="alert">
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            @endif
            @if (session('errors'))
                <div class="row" id="success" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
                    x-transition:leave.duration.3000ms>
                    <div class="col-md-12">
                        <div class="alert bg-danger text-white" role="alert">
                            {{ session('errors') }}
                        </div>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="row" id="success" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
                    x-transition:leave.duration.3000ms>
                    <div class="col-md-12">
                        <div class="alert bg-danger text-white" role="alert">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-header">

                    <div class="card-tools">
                        <a type="button" href="{{ route('indicators') }}" class="btn btn-tool bg-dark"><i
                                class="fas fa-arrow-left"></i>
                            back
                        </a>

                    </div>
                </div>
            </div>
            @if (Auth::user()->role_id == 1)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">

                            <span style="text-transform: uppercase">
                                @if (session('department_name'))
                                    {{ session('department_name') }}
                                @endif
                            </span>
                            <span style="text-transform: capitalize;font-size:0.8em;">/
                                @if (session('indicator'))
                                    {{ session('indicator') }}
                                @endif
                            </span>
                            <small>/New Target</small>
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form role="form" method="post" action="{{ route('create_target') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">


                                    <div class="col-md-6 form-group">
                                        <label>Baseline</label>
                                        <input type="text" class="form-control" name="baseline" placeholder="baseline"
                                            id="exampleInputEmail1">

                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Project Vote Number </label>
                                        <input type="text" class="form-control" name="project_vote_number"
                                            placeholder="project vote number" id="exampleInputEmail1">

                                    </div>



                                </div>
                                <div class="row">


                                    <div class="col-md-6 form-group">
                                        <label>Target Description</label>
                                        <input type="text" class="form-control" name="target_description"
                                            @error('target_description') is-invalid @enderror id="exampleInputEmail1">
                                        @error('target_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Year</label>
                                        <select name="year_id" class="form-control" @error('year_id') is-invalid @enderror>
                                            @if ($years)
                                                @foreach ($years as $year)
                                                    <option value="{{ $year->year_id }}">{{ $year->year }}</option>
                                                @endforeach
                                            @endif


                                        </select>

                                        @error('year_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>

                                </div>
                                <div class="row">

                                </div>
                                <div class="row">


                                    <div class="col-md-6 form-group">
                                        <label>Budget Value</label>
                                        <input type="number" class="form-control" name="budget_value"
                                            @error('budget') is-invalid @enderror id="exampleInputEmail1">
                                        @error('budget')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Targeted Value</label>
                                        <input type="number" class="form-control" name="target_value"
                                            @error('target_value') is-invalid @enderror id="exampleInputEmail1">
                                        @error('target_value')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>



                                </div>



                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            @endif




            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <span style="text-transform: uppercase">
                            @if (session('department_name'))
                                {{ session('department_name') }}
                            @endif
                        </span>
                        <span style="text-transform: capitalize;font-size:0.8em;">/
                            @if (session('indicator'))
                                {{ session('indicator') }}
                            @endif
                        </span>
                        <small>
                            /Targets</small>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>

                                <th>Target Description</th>
                                <th>Budget</th>
                                <th>Target Value</th>
                                <th> Actual Progress </th>
                                <th> Expendidure Progress </th>
                                <th>action</th>

                            </tr>
                        </thead>
                        <tbody>


                            @if ($targets)
                                @foreach ($targets as $key => $target)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td> {{ $target->target_description }}</td>
                                        <td> {{ $target->budget_value }}</td>
                                        <td> {{ $target->target_value }}</td>
                                        <td>
                                            <div class="progress bg-dark">
                                                <div class="progress-bar progress-bar-danger"
                                                    style="width: {{ ($target->total_actuals / $target->target_value) * 100 }}%">
                                                    {{ round(($target->total_actuals / $target->target_value) * 100) }}%
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress bg-dark">
                                                <div class="progress-bar progress-bar-danger"
                                                    style="width: {{ ($target->total_expenditure / $target->budget_value) * 100 }}%">
                                                    {{ round(($target->total_expenditure / $target->budget_value) * 100) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <th>
                                            <form action="{{ route('set_target') }}" class="btn btn-sm" method="post">
                                                @csrf
                                                <input type="hidden" name="target_description"
                                                    value="{{ $target->target_description }}">
                                                <input type="hidden" name="target_id" value="{{ $target->target_id }}">
                                                <input type="hidden" name="year_id" value="{{ $target->year_id }}">
                                                <input type="hidden" name="department_id"
                                                    value="{{ $target->department_id }}">
                                                <button class="btn btn-sm bg-primary2" type="submit">Actuals</button>
                                            </form>
                                            @if (Auth::user()->role_id == 1)
                                                <button class="btn btn-sm bg-primary4" data-toggle="modal"
                                                    data-target="#modal-update{{ $key }}">update</button>
                                                <button class="btn btn-sm bg-primary3" data-toggle="modal"
                                                    data-target="#modal-delete{{ $key }}">delete</button>
                                            @endif
                                        </th>
                                    </tr>

                                    <div class="modal fade" id="modal-delete{{ $key }}">
                                        <div class="modal-dialog modal-md bg-primary1">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confimation </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this target
                                                        {{ $target->target_description }}
                                                        &hellip;</p>
                                                </div>
                                                <form action="{{ route('delete_target') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="target_id"
                                                        value="{{ $target->target_id }}">
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>



                                    {{-- update modal --}}
                                    <div class="modal fade" id="modal-update{{ $key }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Target </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form action="{{ route('update_target') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">


                                                            <div class="col-md-6 form-group">
                                                                <label>Baseline</label>
                                                                <input type="text" class="form-control"
                                                                    name="baseline" placeholder="baseline"
                                                                    value="{{ $target->baseline }}"
                                                                    id="exampleInputEmail1">

                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>Project Vote Number </label>
                                                                <input type="text" class="form-control"
                                                                    name="project_vote_number"
                                                                    value="{{ $target->project_vote_number }}"
                                                                    placeholder="project vote number"
                                                                    id="exampleInputEmail1">

                                                            </div>



                                                        </div>
                                                        <div class="row">

                                                            <input type="hidden" name="target_id"
                                                                value="{{ $target->target_id }}">
                                                            <input type="hidden" name="year_id"
                                                                value="{{ $target->year_id }}">
                                                            <div class="col-md-12 form-group">
                                                                <label>Target Description</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $target->target_description }}"
                                                                    name="target_description" id="exampleInputEmail1">

                                                            </div>



                                                        </div>

                                                        <div class="row">


                                                            <div class="col-md-6 form-group">
                                                                <label>Budget Value</label>
                                                                <input type="number" class="form-control"
                                                                    name="budget_value"
                                                                    value="{{ $target->budget_value }}"
                                                                    id="exampleInputEmail1">

                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>Targeted Value</label>
                                                                <input type="number" class="form-control"
                                                                    name="target_value"
                                                                    value="{{ $target->target_value }}"
                                                                    id="exampleInputEmail1">

                                                            </div>



                                                        </div>



                                                    </div>

                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit"
                                                            class="btn btn1 bg-primary3">update</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                @endforeach
                            @endif




                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.card -->

            <!-- /.card -->
        </div>
    </div>
@endsection
