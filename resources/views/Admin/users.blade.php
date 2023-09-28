@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">New user</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        @if (session('message'))
            <div class="row" id="success" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                x-transition:leave.duration.4000ms>
                <div class="col-md-12">
                    <div class="alert bg-primary1 text-white" role="alert">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        @endif
        @if (session('errors'))
            <div class="row" id="success" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                x-transition:leave.duration.4000ms>
                <div class="col-md-12">
                    <div class="alert bg-danger text-white" role="alert">
                        {{ session('errors') }}
                    </div>
                </div>
            </div>
        @endif


        <div class="card-body">

            <div class="row">
                <div class="col">

                </div>
            </div>
            <form role="form" method="POST" action="{{ route('create_user') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>FullName</label>
                            <input type="text" class="form-control" name='name' placeholder="name">


                        </div>

                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="email">


                        </div>



                    </div>
                    <div class="row">


                        <div class="col-md-6 form-group">
                            <label for="">Phone</label>
                            <input type="number" class="form-control" name="phone" placeholder="phone">


                        </div>
                        <div class="col-md-6 form-group">
                            <label>Department</label>
                            <select type="text" class="form-control" name="department_id" placeholder="department">
                                @if ($departments)
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->department_id }}">{{ $department->department_name }}
                                        </option>
                                    @endforeach
                                @endif

                            </select>


                        </div>



                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Role</label>
                            <select type="text" class="form-control" name="role_id" placeholder="role">
                                @if ($roles)
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role_id }}">{{ $role->role }}
                                        </option>
                                    @endforeach
                                @endif

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


    <div class="card mt-3 ">
        <div class="card-header">
            <h3 class="card-title">Users</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0 ml-3 mr-3 mt-3">
            <table id="example1" class="table table-head-fixed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name </th>
                        <th>Email </th>
                        <th>Phone </th>
                        <th>Department</th>

                        <th>Account Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($users)
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->department_name }}</td>
                                <td><span class="tag tag-success">{{ $user->status }}</span></td>


                                <td>
                                    <button class="btn btn-sm bg-primary1" data-toggle="modal"
                                        data-target="#modal-update{{ $key }}">update</button>


                                </td>
                            </tr>
                            <div class="modal fade" id="modal-update{{ $key }}">
                                <div class="modal-dialog modal-md ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">update department </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="{{ route('update_department') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">


                                                    <div class="col-md-6 form-group">
                                                        <label>Name</label>
                                                        <input type="hidden" name="user_id"
                                                            value="{{ $user->user_id }}">
                                                        <input type="text" value="{{ $user->name }}"
                                                            class="form-control" name="name" placeholder="name">

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Role</label>
                                                        <select type="text" class="form-control" name="role_id"
                                                            placeholder="role">
                                                            @if ($roles)
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->role_id }}">
                                                                        {{ $role->role }}
                                                                    </option>
                                                                @endforeach
                                                            @endif

                                                        </select>
                                                    </div>


                                                </div>
                                                <div class="row">


                                                    <div class="col-md-6 form-group">
                                                        <label for="">Phone</label>
                                                        <input type="number" value="{{ $user->phone }}"
                                                            class="form-control" name="phone" placeholder="phone">


                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Extension</label>
                                                        <label>Department</label>
                                                        <select type="text" class="form-control" name="department_id"
                                                            placeholder="department">
                                                            @if ($departments)
                                                                @foreach ($departments as $department)
                                                                    <option value="{{ $department->department_id }}">
                                                                        {{ $department->department_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif

                                                        </select>


                                                    </div>



                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 form-group">

                                                        <label>Account Active</label>
                                                        <input type="checkbox" name="status" value=true>
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
                    @endif


                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

    </div>
@endsection
