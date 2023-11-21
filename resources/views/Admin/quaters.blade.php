@extends('layouts.app')
@section('content')
    <div class="row mt-2 container-fluid">
        <div class="col-md-12 container">
  
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">

                        <span style="text-transform: uppercase">
                            @if (session('year'))
                                {{ session('year') }}
                            @endif
                        </span>
                        <small>/ New Quarter </small>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" method="post" action="{{ route('create_quarter') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">


                                <div class="col-md-6 form-group">
                                    <label>Quater Name</label>
                                    <input type="text" class="form-control" name="quarter_name"
                                        placeholder="quarter_name">

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Start</label>

                                    <input type="date" name="start_date" class="form-control" id="exampleInputEmail1">



                                </div>
                                <div class="col-md-6 form-group">
                                    <label>End Date</label>

                                    <input type="date" name="end_date" class="form-control" id="exampleInputEmail1">



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
                    <h3 class="card-title"> <span style="text-transform: uppercase">
                            @if (session('year'))
                                {{ session('year') }}
                            @endif
                        </span> <small>/ Quarters</small></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive ml-1 mr-1 mt-3">
                    <table id="example1" class="table  table-head-fixed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Quarters</th>

                                <th>Start Date</th>

                                <th>End Date</th>
<th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($quarters)
                                @foreach ($quarters as $key => $quarter)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $quarter->quarter_name }}</td>
                                        <td>{{ $quarter->start_date->format('Y-m-d') }}</td>
                                        <td>{{ $quarter->end_date->format('Y-m-d') }}</td>
                                        <td>{{ $quarter->status }}</td>
                                        <td>
                                            <button class="btn btn-sm bg-primary2" data-toggle="modal"
                                                data-target="#modal-update{{ $key }}">update</button>
                                            <button class="btn btn-sm bg-primary3" data-toggle="modal"
                                                data-target="#modal-delete{{ $key }}">delete</button>
                                                @if ($quarter->status == 1)
                                                <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#modal-deactivate{{ $key }}">deactivate</button>
                                            @elseif ($quarter->status == 0)
                                                <button class="btn btn-sm bg-primary1" data-toggle="modal"
                                                    data-target="#modal-activate{{ $key }}">Activate</button>
                                            @endif
                                        </td>
                                    </tr>

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
                                                    <p>Are you sure you want to activate
                                                        {{ $quarter->quarter_name }}
                                                        &hellip;</p>
                                                </div>
                                                <form action="{{ route('activate_deactivate_quarter') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="quarter_id" value="{{ $quarter->quarter_id }}">
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
                                                    <p>Are you sure you want to deactivate
                                                        {{ $quarter->quarter_name }}
                                                        &hellip;</p>
                                                </div>
                                                <form action="{{ route('activate_deactivate_quarter') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="quarter_id" value="{{ $quarter->quarter_id }}">
                                                    <input type="hidden" name="status" value="0">
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn bg-danger">deactivate</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
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
                                                    <p>Are you sure you want to delete this quarter
                                                        {{ $quarter->quarter_name }}
                                                        &hellip;</p>
                                                </div>
                                                <form action="{{ route('delete_quarter') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="quarter_id" value="{{ $quarter->quarter_id }}">
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
                                                    <h4 class="modal-title">update quarter </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form action="{{ route('update_quarter') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <input type="hidden" name="quarter_id"
                                                                value="{{ $quarter->quarter_id }}">

                                                            <div class="col-md-6 form-group">
                                                                <label>Quater Name</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $quarter->quarter_name }}" name="quarter_name"
                                                                    placeholder="quarter_name">

                                                            </div>


                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 form-group">
                                                                <label>Start</label>

                                                                <input type="date" name="start_date"
                                                                    value="{{ $quarter->start_date->format('Y-m-d') }}"
                                                                    class="form-control" id="exampleInputEmail1">



                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>End Date</label>

                                                                <input type="date" name="end_date"
                                                                    value="{{ $quarter->end_date->format('Y-m-d') }}"
                                                                    class="form-control" id="exampleInputEmail1">



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
