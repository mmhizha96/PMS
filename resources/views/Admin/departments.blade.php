@extends('layouts.app')
@section('content')
    <div class="row mt-2 container-fluid"">
        <div class="col-md-12 container-fluid">
         
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New Department</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>




                <div class="card-body">

                    <div class="row">
                        <div class="col">

                        </div>
                    </div>
                    <form role="form" method="POST" action="{{ route('create_department') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">


                                <div class="col-md-6 form-group">
                                    <label>Department Name</label>
                                    <input type="text" class="form-control" name="department_name">


                                </div>



                            </div>
                            <div class="row">


                                <div class="col-md-6 form-group">
                                    <label for="">Phone</label>
                                    <input type="number" class="form-control" name="phone" placeholder="phone">

                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Extension</label>
                                    <input type="text" class="form-control" name="extension" placeholder="extension">


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
                    <h3 class="card-title">Departments</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive mt-3 ml-1 mr-1">
                    <table id="example1" class="table table-head-fixed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Deparment Name</th>
                                <th>Extension</th>
                                <th>Phone </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @isset($departments)
                                @foreach ($departments as $key => $dept)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>{{ $dept->department_name }}</td>
                                        <td>{{ $dept->extension }}</td>
                                        <td>{{ $dept->phone }}</td>
                                        <td>
                                            <form action="{{ route('setdepartment') }}" class="btn btn-sm" method="post">
                                                @csrf
                                                <input type="hidden" name="department_name"
                                                    value="{{ $dept->department_name }}">
                                                <input type="hidden" name="department_id" value="{{ $dept->department_id }}">
                                                <button class="btn btn-sm bg-primary2" type="submit">indicators</button>
                                            </form>
                                            <button class="btn btn-sm bg-primary4" data-toggle="modal"
                                                data-target="#modal-update{{ $key }}">update</button>
                                            <button class="btn btn-sm bg-primary3" data-toggle="modal"
                                                data-target="#modal-delete{{ $key }}">delete</button>

                                        </td>

                                    </tr>

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

                                                <form action="{{ route('update_department') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">


                                                            <div class="col-md-6 form-group">
                                                                <label>Department Name</label>
                                                                <input type="hidden" name="department_id"
                                                                    value="{{ $dept->department_id }}">
                                                                <input type="text" value="{{ $dept->department_name }}"
                                                                    class="form-control" name="department_name"
                                                                    placeholder="department name">

                                                            </div>



                                                        </div>
                                                        <div class="row">


                                                            <div class="col-md-6 form-group">
                                                                <label for="">Phone</label>
                                                                <input type="number" value="{{ $dept->phone }}"
                                                                    class="form-control" name="phone" placeholder="phone">


                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>Extension</label>
                                                                <input type="text" value="{{ $dept->extension }}"
                                                                    class="form-control" name="extension"
                                                                    placeholder="extension">


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
                                                        {{ $key }}
                                                        &hellip;</p>
                                                </div>
                                                <form action="{{ route('delete_department') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="department_id"
                                                        value="{{ $dept->department_id }}">
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
