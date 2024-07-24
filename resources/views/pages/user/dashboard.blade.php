@extends('app')

@section('content')
    <div id="layout-wrapper">
        @include('layouts.navbar', ['page' => '<i class="bx bx-home-alt me-2"></i> Dashboard'])
        @include('layouts.sidebar')
        @include('layouts.horizontal-topbar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row mt-4">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Franchise Validity</h5>
                                        </div>
                                        <div class="flex-shrink-0">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div>
                                        <div id="chart-radialBar" class="mb-4"
                                            data-colors='["#556ee6", "#34c38f", "#f46a6a"]'></div>

                                        @php
                                            $expiresOn = new DateTime($user->expiresOn);
                                            $createdAt = new DateTime($user->created_at);
                                            $today = new DateTime();
                                            $daysRemaining = 0;
                                            $percentageRemaining = 0;

                                            if ($user->status == 2 && $user->isActive == 1) {
                                                $year = $today->format('Y');
                                                $totalDaysInYear =
                                                    $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0)
                                                        ? 366
                                                        : 365;

                                                if ($expiresOn >= $today) {
                                                    $daysRemaining = $expiresOn->diff($today)->format('%a');

                                                    if ($daysRemaining < 0) {
                                                        $daysRemaining = 0;
                                                    }

                                                    $percentageRemaining = ($daysRemaining / $totalDaysInYear) * 100;
                                                } else {
                                                    $percentageRemaining = 0;
                                                }
                                            }
                                        @endphp

                                        <script>
                                            function getChartColorsArray(r) {
                                                if (null !== document.getElementById(r)) {
                                                    var e = document.getElementById(r).getAttribute("data-colors");
                                                    return (e = JSON.parse(e)).map(function(r) {
                                                        var e = r.replace(" ", "");
                                                        if (-1 == e.indexOf("--")) return e;
                                                        var t = getComputedStyle(document.documentElement).getPropertyValue(e);
                                                        return t || void 0;
                                                    });
                                                }
                                            }

                                            var options = {
                                                series: [{{ $percentageRemaining }}],
                                                chart: {
                                                    type: "radialBar",
                                                    height: 450,
                                                    sparkline: {
                                                        enabled: true
                                                    },
                                                    animations: {
                                                        enabled: true,
                                                        easing: 'easeinout',
                                                        speed: 2000
                                                    }
                                                },
                                                plotOptions: {
                                                    radialBar: {
                                                        startAngle: -90,
                                                        endAngle: 90,
                                                        track: {
                                                            background: "#e6ecf9",
                                                            strokeWidth: "97%",
                                                            margin: 5,
                                                            dropShadow: {
                                                                enabled: false,
                                                                top: 2,
                                                                left: 0,
                                                                color: "#999",
                                                                opacity: 1,
                                                                blur: 2
                                                            }
                                                        },
                                                        hollow: {
                                                            margin: 15,
                                                            size: "65%"
                                                        },
                                                        dataLabels: {
                                                            name: {
                                                                show: true,
                                                                text: 'Days Left',
                                                                color: '#888',
                                                                fontSize: '13px',
                                                                offsetY: -10,

                                                            },
                                                            value: {
                                                                show: true,
                                                                formatter: function(val) {
                                                                    return '{{ $daysRemaining }} days';
                                                                },
                                                                offsetY: 4,
                                                                fontSize: "22px",
                                                                fontWeight: 'bold',
                                                                color: '#111',

                                                            }
                                                        }
                                                    }
                                                },
                                                grid: {
                                                    padding: {
                                                        bottom: 20
                                                    }
                                                },
                                                fill: {
                                                    opacity: 1,
                                                    type: 'gradient',
                                                    gradient: {
                                                        shade: 'dark',
                                                        shadeIntensity: 0.15,
                                                        inverseColors: false,
                                                        opacityFrom: 1,
                                                        opacityTo: 1,
                                                        stops: [0, 50, 65, 91]
                                                    },
                                                },

                                                stroke: {
                                                    dashArray: 4
                                                },
                                                colors: getChartColorsArray("chart-radialBar"),
                                                labels: ["Days Remaining"],
                                            };

                                            var chart = new ApexCharts(document.querySelector("#chart-radialBar"), options);
                                            chart.render();
                                        </script>

                                        <div class="text-center mt-4">
                                            <p class="text-muted">Status:
                                                @if ($user->isActive == 1)
                                                    <span class="text-success fw-bold">Valid</span>
                                                @endif
                                                @if ($user->isActive == 0)
                                                    @if ($user->status == 1)
                                                        <span class="text-primary fw-bold">For Payment & Signature/s</span>
                                                    @endif
                                                    @if ($user->status == 2)
                                                        <span class="text-danger fw-bold">Expired</span>
                                                    @endif
                                                    @if ($user->status == 3)
                                                        <span class="text-danger fw-bold">Pending</span>
                                                    @endif
                                                    @if ($user->status == 4)
                                                        <span class="text-primary fw-bold">For Payment & Signature/s</span>
                                                    @endif
                                                @endif
                                            </p>
                                            @if ($user->status == 2)
                                                @if ($user->isActive == 0)
                                                    <button href="javascript:;" class="btn btn-success btn-sm shadow-lg"
                                                        id="renew-franchise">Renew Franchise</button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <hr class="mb-0 mt-3">
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    <div class="mt-3 px-1 pt-1">
                                        <div class="table-responsive">
                                            <div class="text-center mb-4">
                                                <button type="button"
                                                    class="btn bg-warning text-dark fw-bold fs-2 btn-lg p-2 rounded-1 shadow-lg">{{ Auth::user()->categories->category }}
                                                    - {{ sprintf('%03d', Auth::user()->name) }}</button>
                                            </div>
                                            <h6 class="ms-2 text-center">{{ $user->applicant }}</h6>
                                            <p class="fw-normal text-center">{{ ucwords(strtolower($user->address)) }}</p>
                                            <table class="table table-hover text-nowrap text-center"
                                                style="font-size: 13px;">
                                                <thead>
                                                    <tr>
                                                        <th>UNIT</th>
                                                        <th>MOTOR NO.</th>
                                                        <th>CHASSIS NO.</th>
                                                        <th>PLATE NO.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $user->make }}</td>
                                                        <td>{{ $user->motorNumber }}</td>
                                                        <td>{{ $user->chassisNumber }}</td>
                                                        <td>{{ $user->plateNumber }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @if ($user->isActive == 1)
                                                <p class="fw-normal text-center" style="font-size: 13px;">
                                                    <span class="text-muted">Renew/Applied on: </span>
                                                    <span
                                                        class="text-success">{{ date('F d, Y', strtotime($user->created_at)) }}</span>
                                                </p>
                                                <p class="fw-normal text-center" style="font-size: 13px;">
                                                    <span class="text-muted">Expires on: </span>
                                                    <span
                                                        class="text-danger">{{ date('F d, Y', strtotime($user->expiresOn)) }}</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('layouts.footer-auth')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



@endsection
