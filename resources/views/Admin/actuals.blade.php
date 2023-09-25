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
            <div class="card">
                <div class="card-header">

                    <div class="card-tools">
                        <a type="button" href="{{ route('targets') }}" class="btn btn-tool bg-dark"><i
                                class="fas fa-arrow-left"></i>
                            back
                        </a>

                    </div>
                </div>
            </div>
            @if (Auth::user()->role_id == 2)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">

                            <span style="text-transform: uppercase">
                                @if (session('department_name'))
                                    {{ session('department_name') }}
                                @endif
                            </span>
                            <small>/ New Actual </small>
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
                        <form role="form" method="post" action="{{ route('create_actual') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">


                                    <div class="col-md-6 form-group">
                                        <label>Actual Description</label>
                                        <input type="text" class="form-control" name="actual_description"
                                            id="exampleInputEmail1">

                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Quarter</label>
                                        <select name="quarter_id" class="form-control">
                                            @if ($quarters)
                                                @foreach ($quarters as $quarter)
                                                    <option value="{{ $quarter->quarter_id }}">{{ $quarter->quarter_name }}
                                                    </option>
                                                @endforeach
                                            @endif


                                        </select>



                                    </div>

                                </div>
                                <div class="row">

                                </div>
                                <div class="row">


                                    <div class="col-md-6 form-group">
                                        <label>Expenditure</label>
                                        <input type="number" class="form-control" name="expenditure"
                                            id="exampleInputEmail1">

                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Actual Value</label>
                                        <input type="number" class="form-control" name="actual_value"
                                            id="exampleInputEmail1">

                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>File</label>
                                        <input type="file" class="form-control" name="file"
                                            accept=".pdf,.xlx,.csv,.docx" id="exampleInputEmail1">

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
                    <h3 class="card-title"> <span style="text-transform: uppercase">
                            @if (session('department_name'))
                                {{ session('department_name') }}
                            @endif
                        </span> <small>/ Actuals</small></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed">
                        <thead>
                            <tr>
                                <th>#</th>


                                <th>Description</th>
                                <th>Quarter</th>
                                <th>Target</th>
                                <th>Expenditure</th>
                                <th>Actual Value</th>
                                <th>Date Created </th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($actuals)
                                @foreach ($actuals as $key => $actual)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $actual->actual_description }}</td>
                                        <td>{{ $actual->quarter_name }}</td>
                                        <td>{{ $actual->target_description }}</td>
                                        <td>{{ $actual->expenditure }}</td>
                                        <td>{{ $actual->actual_value }}</td>
                                        <td>{{ $actual->created_at }}</td>

                                        <td>
                                            <a class="btn btn-sm bg-primary1" href="uploads/{{ $actual->document_path }}">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                            @if (Auth::user()->role_id == 1)
                                                <button class="btn btn-sm bg-primary3" data-toggle="modal"
                                                    data-target="#modal-delete{{ $key }}">delete</button>
                                            @endif



                                        </td>
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
                                                        <p>Are you sure you want to delete this department
                                                            {{ $actual->actual_description }}
                                                            &hellip;</p>
                                                    </div>
                                                    <form action="{{ route('delete_actual') }}" method="post">
                                                        @csrf

                                                        <input type="hidden" name="actual_id"
                                                            value="{{ $actual->actual_id }}">
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
                                    </tr>
                                @endforeach
                            @endisset

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

            <!-- /.card -->
        </div>
    </div>
@endsection
