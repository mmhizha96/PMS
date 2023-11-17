@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">Dashboard/
                        @if (session('department'))
                            {{ session('department')->department_name }}
                        @endif

                    </h4>
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



                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary3">
                        <div class="inner">
                            <h3>
                                @if ($indicators_total)
                                    {{ $indicators_total }}
                                @else
                                    {{ 0 }}
                                @endif
                            </h3>

                            <p>INDICATORS</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>

                        <a href="{{ route('indicators') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary1">
                        <div class="inner">
                            <h3>
                                @if ($targets_total)
                                    {{ $targets_total }}
                                @else
                                    {{ 0 }}
                                @endif

                            </h3>
                            <p>TARGETS</p>

                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href=" {{ route('set_my_indicator') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

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
                        <h3 class="card-title">BAR CHART</h3>

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
                        <div class="chart">
                            <canvas id="barChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 95%;"></canvas>
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

        var target_summary = [];
        var targetValue = [];
        var actuals = [];



        @foreach ($target_reports as $target_repo)
            target_summary.push('{{ $target_repo->target_summary }}');
            targetValue.push('{{ $target_repo->target_value }}');
            actuals.push('{{ $target_repo->total_actuals }}');
        @endforeach

        var pieTotal = [0, 0, 0];
        var pieComment = ["not achieved", "achieved", "over achieved"];


        @foreach ($piereportData as $pierepo)
            @if ($pierepo->decision == 'not_achieved')
                pieTotal[0] = pieTotal[0] + {{ $pierepo->total_decision }}
            @elseif ($pierepo->decision == 'achieved')
                pieTotal[1] = pieTotal[1] + {{ $pierepo->total_decision }}
            @elseif ($pierepo->decision == 'over_achieved')
                pieTotal[2] = pieTotal[2] + {{ $pierepo->total_decision }}
            @endif
        @endforeach
        var areaChartData = {

            labels: target_summary,
            datasets: [{
                    label: 'target',
                    backgroundColor: '#838339',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: targetValue
                },
                {
                    label: 'actuals',
                    backgroundColor: '#8bbd3a;',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: actuals
                },


            ]
        }
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0



        new Chart(barChartCanvas, {

            type: 'bar',
            data: barChartData,
            options: {

                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0, // minimum will be 0, unless there is a lower value.

                        }
                    }]
                }
            }

        })

        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = {
            labels: pieComment,
            datasets: [{
                data: pieTotal,
                backgroundColor: ['#fcc425', '#838339', '#618429'],
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

    })
</script>
