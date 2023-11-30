@extends('layouts.app')
@section('content')
    <div class="row mt-2 container-fluid">
        <div class="col-md-12 ">


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
                                    <div class="col-md-6 form-group">
                                        <label for="">Department</label>
                                        <select name="department_id" required class="form-control">

                                            <option>select department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->department_id }}"
                                                    {{ $department->department_id == session('department_id') ? 'selected' : '' }}>
                                                    {{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
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
                <div class="card-body ">
                    <table id="example1" class="table table-stripped table-hover">
                        <thead>
                            <tr>
                                <th data-priority="2">#</th>
                                <th data-priority="0">Indicator</th>
                                <th data-priority="2">Description</th>
                                <th data-priority="3">Department</th>
                                <th data-priority="5">Date Created </th>
                                <th data-priority="0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($indicators)
                                @foreach ($indicators as $key => $indicator)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $indicator->indicator }}</td>
                                        <td>{{ $indicator->description }}</td>
                                        <td>{{ $indicator->department_name }}</td>
                                        <td>{{ $indicator->created_at }}</td>

                                        <td>


                                            <div class="btn-group">
                                                <svg width="35px" data-toggle="dropdown" viewBox="-0.5 0 25 25" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M12 14.5C13.1046 14.5 14 13.6046 14 12.5C14 11.3954 13.1046 10.5 12 10.5C10.8954 10.5 10 11.3954 10 12.5C10 13.6046 10.8954 14.5 12 14.5Z"
                                                            stroke="#0F0F0F" stroke-miterlimit="10"></path>
                                                        <path
                                                            d="M19.5 14.5C20.6046 14.5 21.5 13.6046 21.5 12.5C21.5 11.3954 20.6046 10.5 19.5 10.5C18.3954 10.5 17.5 11.3954 17.5 12.5C17.5 13.6046 18.3954 14.5 19.5 14.5Z"
                                                            stroke="#0F0F0F" stroke-miterlimit="10"></path>
                                                        <path
                                                            d="M4.5 14.5C5.60457 14.5 6.5 13.6046 6.5 12.5C6.5 11.3954 5.60457 10.5 4.5 10.5C3.39543 10.5 2.5 11.3954 2.5 12.5C2.5 13.6046 3.39543 14.5 4.5 14.5Z"
                                                            stroke="#0F0F0F" stroke-miterlimit="10"></path>
                                                    </g>
                                                </svg>

                                                <span class="sr-only">Toggle Dropdown</span>

                                                <div class="dropdown-menu" style="margin-right: 70px" role="menu">

                                                    <form action="{{ route('set_indicator') }}" style="width: 100%"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="description"
                                                            value="{{ $indicator->description }}">
                                                        <input type="hidden" name="indicator"
                                                            value="{{ $indicator->indicator }}">
                                                        <input type="hidden" name="indicator_id"
                                                            value="{{ $indicator->indicator_id }}">
                                                        <button style="text-align: left" class="btn btn-sm form-control"
                                                            type="submit">Targets</button>
                                                    </form>
                                                    @if (Auth::user()->role_id == 1)
                                                        <button class="btn btn-sm dropdown-item" data-toggle="modal"
                                                            data-target="#modal-update{{ $key }}">Update</button>
                                                        <button class="btn btn-sm dropdown-item" data-toggle="modal"
                                                            data-target="#modal-delete{{ $key }}">Delete</button>
                                                    @endif

                                                </div>





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
