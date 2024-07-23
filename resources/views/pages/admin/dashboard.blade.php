@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

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
                        <div class="col-md-3">
                            <div class="row">
                                @foreach ($categories as $cat)
                                    <div class="col-md-12">
                                        <a wire:navigate
                                            href="{{ route('admin.view-category', ['id' => $aes->encrypt($cat->id)]) }}?{{ \Str::random(20) }}">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="font-size-15">{{ $cat->category }} -
                                                                {{ $cat->color }}</h6>
                                                            <h4 class="mt-1 pt-1 mb-0 font-size-22">{{ $cat->users_count }}
                                                                <span
                                                                    class="text-success fw-medium font-size-14 align-middle">
                                                                    <i class="mdi mdi-arrow-up"></i>Total </span> </h4>
                                                        </div>
                                                        <div class="">
                                                            <div class="avatar">
                                                                <div class="avatar-title rounded bg-primary-subtle ">
                                                                    <img src="{{ asset('storage/icons/tricycle.png') }}"
                                                                        height="30" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body pb-0">

                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-4">Overview
                                            <p class="d-lg-none d-md-none d-sm-block text-primary mt-2"
                                                style="font-size: 13px">Long Press the shades to display data</p>
                                        </h5>
                                    </div>

                                    <div class="row">
                                        @foreach ($categories as $cat)
                                            <div class="col-md-6 mb-4">
                                                <h6 class="text-secondary">{{ $cat->category }} - {{ $cat->color }}</h6>
                                                <div id="chart-{{ $cat->id }}"></div>
                                            </div>
                                        @endforeach
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>


                    <script>
                        @foreach ($categories as $cat)

                            @php
                                $activeCount = $cat->active_franchises_count;
                                $inactiveCount = $cat->expired_franchises_count;
                                $totalCount = $cat->users_count;

                                $active = 0;
                                $inactive = 0;

                                if ($totalCount != 0) {
                                    $active = ($activeCount / $totalCount) * 100;
                                    $inactive = ($inactiveCount / $totalCount) * 100;
                                }
                            @endphp

                            var options = {
                                series: [{{ number_format($active, 1) }}, {{ number_format($inactive, 1) }}],
                                chart: {
                                    height: 390,
                                    type: 'radialBar',
                                    animations: {
                                        enabled: true,
                                        easing: 'easeinout',
                                        speed: 1500
                                    }
                                },
                                plotOptions: {
                                    radialBar: {
                                        offsetY: 0,
                                        startAngle: 0,
                                        endAngle: 270,
                                        hollow: {
                                            margin: 5,
                                            size: '30%',
                                            background: 'transparent',
                                            image: undefined,
                                        },

                                        barLabels: {
                                            enabled: true,
                                            useSeriesColors: true,
                                            offsetX: -8,
                                            fontSize: '13px',
                                        },
                                    }
                                },
                                stroke: {
                                    colors: ['#fff'],
                                },
                                fill: {
                                    opacity: 0.8
                                },
                                labels: ['Active: {{ $activeCount }}', 'Inactive: {{ $inactiveCount }}'],
                                colors: ['rgb(87, 183, 141)', '#FF0000'],
                                responsive: [{
                                    breakpoint: 480,
                                    options: {
                                        legend: {
                                            show: false
                                        }
                                    }
                                }]
                            };

                            var chart = new ApexCharts(document.querySelector("#chart-{{ $cat->id }}"), options);
                            chart.render();
                        @endforeach
                    </script>

                    <style>
                        .class {
                            color: rgb(87, 183, 141)
                        }
                    </style>
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
