@extends('layouts.app')
@section('content')
    <div class="row mt-2 container-fluid">
        <div class="col-md-12">
            @if (session('errors'))
                <div class="row" id="success" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
                    x-transition:leave.duration.3000ms>
                    <div class="col-md-12">
                        <div class="alert bg-danger text-white" role="alert">

                            @foreach (session('errors')->toArray() as $errors)
                                @foreach ($errors as $error)
                                    {{ $error }} ,
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New Years</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('create_year') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>year</label>
                                    <input type="text" class="form-control" name="year" placeholder="enter year">

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



            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Years</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive  mr-1 ml-1 mt-3">
                    <table id="example1" class="table table-head-fixed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Year</th>
                                <th>status</th>
                                <th data-priority="1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($years)
                                @foreach ($years as $key => $year)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $year->year }}</td>
                                        <td>{{ $year->status }}</td>
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


                                                    <form action="{{ route('set_year') }}" style="width: 100%"
                                                        class="btn btn-sm" method="post">
                                                        @csrf
                                                        <input type="hidden" name="year" value="{{ $year->year }}">
                                                        <input type="hidden" name="year_id" value="{{ $year->year_id }}">
                                                        <button style="text-align: left"
                                                            class="btn btn-sm form-control dropdown-item"
                                                            type="submit">Quaters</button>
                                                    </form>
                                                    <button class="btn btn-sm  dropdown-item" data-toggle="modal"
                                                        data-target="#modal-delete{{ $key }}">Delete</button>
                                                    @if ($year->status == 1)
                                                        <button class="btn btn-sm dropdown-item" data-toggle="modal"
                                                            data-target="#modal-deactivate{{ $key }}">Deactivate</button>
                                                    @elseif ($year->status == 0)
                                                        <button class="btn btn-sm dropdown-item " data-toggle="modal"
                                                            data-target="#modal-activate{{ $key }}">Activate</button>
                                                    @endif

                                                </div>
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
                                                    <p>Are you sure you want to delete this year
                                                        {{ $year->year }}
                                                        &hellip;</p>
                                                </div>
                                                <form action="{{ route('delete_year') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="year_id" value="{{ $year->year_id }}">
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
                                    <div class="modal fade" id="modal-activate{{ $key }}">
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
                                                    <p>Are you sure you want to activate this year
                                                        {{ $year->year }}
                                                        &hellip;</p>
                                                </div>
                                                <form action="{{ route('activate_deactivate_year') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="year_id" value="{{ $year->year_id }}">
                                                    <input type="hidden" name="status" value="1">
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn bg-primary1">activate</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>

                                    <div class="modal fade" id="modal-deactivate{{ $key }}">
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
                                                    <p>Are you sure you want to deactivate this year
                                                        {{ $year->year }}
                                                        &hellip;</p>
                                                </div>
                                                <form action="{{ route('activate_deactivate_year') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="year_id" value="{{ $year->year_id }}">
                                                    <input type="hidden" name="status" value="0">
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">deactivate</button>
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
