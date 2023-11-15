@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">Dashboard</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-warning"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary4">
                        <div class="inner">
                            <h3>
                                @if ($departments_total)
                                    {{ $departments_total }}
                                @endif
                            </h3>

                            <p>DEPARTMENTS</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-th"></i>
                        </div>
                        <a href="{{ route('departments') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary3">
                        <div class="inner">
                            <h3>
                                @if ($indicators_total)
                                    {{ $indicators_total }}
                                @endif
                            </h3>

                            <p>INDICATORS</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a  class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary1">
                        <div class="inner">
                            <h3>
                                @if ($targets_total)
                                    {{ $targets_total }}
                                @endif
                            </h3>
                            <p>TARGETS</p>

                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('set_my_indicator') }}" class="small-box-footer"> More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary2">
                        <div class="inner">
                            <h3>
                                @if ($users_total)
                                    {{ $users_total }}
                                @endif
                            </h3>

                            <p>USERS</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
            <!-- /.row -->
            <div class="row">
                <div class="card  col-md-6 container">
                    <div class="card-header">
                        <h3 class="card-title">Donut Chart</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 95%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card col-md-6 container">
                    <div class="card-header">
                        <h3 class="card-title">TARGET PERCENTAGE PER DEPARTMENT</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="stackedChartID"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- /.content-wrapper -->
@endsection

<script src="plugins/jquery/jquery.min.js"></script>

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
    $(function() {

        var departments = [];
        var achieved = [];
        var exceeded = [];
        var not_achieved = [];

        var i = 0;
        @foreach ($target_reports as $target_repo)
            if (!departments.includes('{{ $target_repo->department_name }}')) {
                departments.push('{{ $target_repo->department_name }}');
                achieved.push(0);
                exceeded.push(0);
                not_achieved.push(0);
                @if ($target_repo->target_value - $target_repo->total_actuals == 0)
                    achieved[i] = achieved[i] + 1;
                @elseif ($target_repo->target_value - $target_repo->total_actuals < 0)
                    exceeded[i] = exceeded[i] + 1;
                @elseif ($target_repo->target_value - $target_repo->total_actuals > 0)
                    not_achieved[i] = not_achieved[i] + 1;
                @endif
            } else {
                let index = departments.findIndex(x => x == '{{ $target_repo->department_name }}');
                @if ($target_repo->target_value - $target_repo->total_actuals == 0)
                    achieved[index] = achieved[index] + 1;
                @elseif ($target_repo->target_value - $target_repo->total_actuals < 0)
                    exceeded[index] = exceeded[index] + 1;
                @elseif ($target_repo->target_value - $target_repo->total_actuals > 0)
                    not_achieved[index] = not_achieved[index] + 1;
                @endif
            }

            i++;
        @endforeach


        for (let i = 0; i < achieved.length; i++) {

            total = achieved[i] + not_achieved[i] + exceeded[i];

            achieved[i] = Math.round((achieved[i] / total) * 100);

            not_achieved[i] = Math.round((not_achieved[i] / total) * 100);

            exceeded[i] = Math.round((exceeded[i] / total) * 100);
        }




        //-------------
        // Get context with jQuery - using jQuery's .get() method.

        var pieTotal = [0, 0, 0];
        var pieComment = ["not achieved", "achieved", "over achieved"];


        @foreach ($piereportData as $pierepo)
            @if ($pierepo->total_actuals < $pierepo->target_value)
                pieTotal[0] = pieTotal[0] + 1
            @elseif ($pierepo->total_actuals == $pierepo->target_value)
                pieTotal[1] = pieTotal[1] + 1
            @elseif ($pierepo->total_actuals > $pierepo->target_value)
                pieTotal[2] = pieTotal[2] + 1
            @endif
        @endforeach
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = {
            labels: pieComment,
            datasets: [{
                data: pieTotal,
                backgroundColor: ['#8bbd3a;', '#838339', '#618429'],
            }]
        }
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })

        // Get the drawing context on the canvas
        var myContext = document.getElementById(
            "stackedChartID").getContext('2d');
        var myChart = new Chart(myContext, {
            type: 'bar',
            data: {
                labels: departments,
                datasets: [{
                    label: 'not_achieved',
                    backgroundColor: '#fcc425',
                    data: not_achieved,
                }, {
                    label: 'achieved',
                    backgroundColor: '#8bbd3a',
                    data: achieved,
                }, {
                    label: 'over achieved',
                    backgroundColor: '#618429',
                    data: exceeded,
                }],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Target percentage per department'
                    },
                },
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            reversed: true,

                            min: 0,
                            max: 100,
                            callback: function(value) {
                                return value + "%"
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Target Percentage"
                        }
                    }]
                }
            }
        });


    })
</script>
