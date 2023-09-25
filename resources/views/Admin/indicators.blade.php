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

            @if (Auth::user()->role_id == 1)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">

                            <span style="text-transform: uppercase">
                                @if (session('department_name'))
                                    {{ session('department_name') }}
                                @endif
                            </span>
                            <small>/ New Indicator </small>
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
                        <form role="form" method="post" action="{{ route('create_indicator') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">


                                    <div class="col-md-6 form-group">
                                        <label>KPI Type</label>
                                        <input type="text" class="form-control @error('kpi_type') is-invalid @enderror"
                                            name="kpi_type" placeholder="kpi_type">
                                        @error('kpi_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Indicator</label>
                                        <input type="text" class="form-control @error('indicator') is-invalid @enderror"
                                            name="indicator" placeholder="indicator">
                                        @error('indicator')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    @isset($department_id)
                                        <input type="text" hidden name="department_id" value="{{ $department_id }}"
                                            class="form-control" id="exampleInputEmail1">
                                    @endisset


                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Description</label>


                                        <textarea ALIGN=LEFT name="description" @error('description') is-invalid @enderror class="form-control" cols="30"
                                            rows="2">

                                    </textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>




                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn bg-primary1">Submit</button>
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
                        </span> <small>/ Indicators</small></h3>
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
                                <th>Indicator</th>

                                <th>Description</th>

                                <th>Date Created </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($indicators)
                                @foreach ($indicators as $key => $indicator)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $indicator->indicator }}</td>
                                        <td>{{ $indicator->description }}</td>
                                        <td>{{ $indicator->created_at }}</td>

                                        <td>
                                            <form action="{{ route('set_indicator') }}" class="btn btn-sm" method="post">
                                                @csrf
                                                <input type="hidden" name="description" value="{{ $indicator->description }}">
                                                <input type="hidden" name="indicator" value="{{ $indicator->indicator }}">
                                                <input type="hidden" name="indicator_id"
                                                    value="{{ $indicator->indicator_id }}">
                                                <button class="btn btn-sm bg-primary2" type="submit">targets</button>
                                            </form>
                                            @if (Auth::user()->role_id == 1)
                                                <button class="btn btn-sm bg-primary4" data-toggle="modal"
                                                    data-target="#modal-update{{ $key }}">update</button>
                                                <button class="btn btn-sm bg-primary3" data-toggle="modal"
                                                    data-target="#modal-delete{{ $key }}">delete</button>
                                            @endif



                                        </td>
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
                                                    <p>Are you sure you want to delete this indicator
                                                        {{ $indicator->indicator }}
                                                        &hellip;</p>
                                                </div>
                                                <form action="{{ route('delete_indicator') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="indicator_id"
                                                        value="{{ $indicator->indicator_id }}">
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
                                        <div class="modal-dialog modal-md ">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">update department </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form action="{{ route('update_indicator') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">


                                                            <div class="col-md-12 form-group">
                                                                <label>Indicator</label>
                                                                <input type="hidden" name="indicator_id"
                                                                    value="{{ $indicator->indicator_id }}">
                                                                <input type="text" value="{{ $indicator->indicator }}"
                                                                    class="form-control @error('indicator') is-invalid @enderror"
                                                                    name="indicator" required placeholder="department name">


                                                            </div>



                                                        </div>
                                                        <div class="row">


                                                            <div class="col-md-12 form-group">

                                                                <label>Description</label>


                                                                <textarea ALIGN=LEFT name="description" @error('description') is-invalid @enderror class="form-control"
                                                                    cols="30" rows="2">
                                                                        {{ $indicator->description }}
                                                                    </textarea>

                                                            </div>




                                                        </div>



                                                    </div>

                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn1 bg-primary3">update</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
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
