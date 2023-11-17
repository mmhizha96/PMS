@extends('layouts.app')
@section('content')

 <div class="container-fluid">
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
    <div class="card-body   ml-1 mr-1 mt-3 ">
        <table id="example1" class="table table-head-fixed">
            <thead>
                <tr>
                    <th>#</th>


                    <th>Description</th>
                    <th>Quarter</th>
                    <th>Year</th>
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
                            <td>{{ $actual->year }}</td>
                            <td>{{ $actual->expenditure }}</td>
                            <td>{{ $actual->actual_value }}</td>
                            <td>{{ $actual->created_at }}</td>

                            <td>
                                <a class="btn btn-sm bg-primary1" href="uploads/{{ $actual->document_path }}">
                                    <i class="fa fa-download" aria-hidden="true"></i> download
                                </a>
                                @if (Auth::user()->role_id == 3)
                                    <button class="btn btn-sm bg-primary3" data-toggle="modal"
                                        data-target="#modal-approve{{ $key }}">approve</button>
                                    <button class="btn btn-sm bg-primary4" data-toggle="modal"
                                        data-target="#modal-reject{{ $key }}">reject</button>
                                @endif



                            </td>
                            <div class="modal fade" id="modal-approve{{ $key }}">
                                <div class="modal-dialog modal-md bg-primary1">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Confimation </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to approve
                                                {{ $actual->actual_description }}
                                                &hellip;</p>
                                        </div>
                                        <form action="{{ route('approve_reject') }}" method="post">
                                            @csrf

                                            <input type="hidden" name="actual_id" value="{{ $actual->actual_id }}">
                                            <input type="hidden" name="status" value="1">
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn bg-primary3"> <i class="fa fa-thumbs-up"
                                                        aria-hidden="true"></i> approve</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <div class="modal fade" id="modal-reject{{ $key }}">
                                <div class="modal-dialog modal-md bg-primary1">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Confimation </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('approve_reject') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="status" value="2">
                                                <input type="hidden" name="actual_id" value="{{ $actual->actual_id }}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for=""> Reason</label>
                                                        <input type="text" class="form-control" required
                                                            name="reason_for_rejection">
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="fa fa-thumbs-down" aria-hidden="true"></i>reject</button>
                                                </div>
                                            </form>
                                        </div>

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
 </div>
@endsection
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
