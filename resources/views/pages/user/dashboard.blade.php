@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div id="layout-wrapper">
        @include('layouts.navbar', ['page' => '<div class="d-flex align-items-center"><iconify-icon icon="flat-color-icons:doughnut-chart" width="24" height="24" class="me-2"></iconify-icon> Dashboard</div>'])
        @include('layouts.sidebar')
        @include('layouts.horizontal-topbar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- this displays the remaining days of validity of the franchise. -->

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


                                    <div class="row mt-4">

                                        <div class="col-md-12">
                                            
                                                <h6 class="text-center mb-4">Progress Overview</h6>
                                        
                                                <div class="row">
                                                    <!-- Track 2 (Disabled) -->
                                                    <div class="col-md-3">
                                                        <div class="card mb-3 {{ 
                                                            
                                                            ($user->status == 0 || $user->status == 1 || $user->status == 2 || $user->status == 3 || $user->status == 4) && 
                                                            ($user->isActive == 0 || $user->isActive == 1) &&
                                                            (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d'))
                                                            
                                                            ? 'border-primary' : 'border-secondary opacity-50' }}">

                                                            <div class="card-header p-3 {{ 
                                                            
                                                            ($user->status == 0 || $user->status == 1 || $user->status == 2 || $user->status == 3 || $user->status == 4) && 
                                                            ($user->isActive == 0 || $user->isActive == 1) &&
                                                            (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d'))
                                                            
                                                            ? 'bg-primary text-white' : 'bg-light text-muted' }}">
                                                                
                                                                <div class="d-flex justify-content-between">
                                                                    <small class="fw-bold">Registration</small>
                                                                    <iconify-icon icon="uiw:d-arrow-right" width="22"></iconify-icon>
                                                                </div>
                                                            </div>
                                                            <div class="card-body text-center">
                                                                @if(($user->status == 0 || $user->status == 1 || $user->status == 2 || $user->status == 3 || $user->status == 4) && ($user->isActive == 0 || $user->isActive == 1) && (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d')))
                                                                
                                                                @if ($user->hasComment == 1)
                                                                <div>
                                                                    <small class="text-danger">Application rejected. See details below </small>
                                                                </div>
                                                                @else
                                                                    <small class="fw-bold">{{ date('M d, Y', strtotime($user->dateSubmitted)) }}</small>
                                                                
                                                                    <br>
                                                                    <small class=""><span style="font-size: 12px">Status:</span> <span class="badge bg-success">Done</span></small>
                                                                    <br>
                                                                    <small style="font-size: 12px">Your requirements has been submitted to the office for review</small>
                                                                @endif

                                                                @else
                                                                -
                                                                <br>
                                                                <small class=""><span style="font-size: 12px">Status:</span> <span class="badge bg-danger">No Application Yet</span></small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Track 2 (Disabled) -->
                                                    <div class="col-md-3">
                                                        <div class="card mb-3 {{

                                                            ($user->status == 0 || $user->status == 1 || $user->status == 2 || $user->status == 3 || $user->status == 4) && 
                                                            ($user->isActive == 0 || $user->isActive == 1) &&
                                                            (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d')) &&
                                                            $user->hasComment == null

                                                            ? 'border-primary' : 'border-secondary opacity-50' }}">

                                                            <div class="card-header p-3 {{ 

                                                            ($user->status == 0 || $user->status == 1 || $user->status == 2 || $user->status == 3 || $user->status == 4) && 
                                                            ($user->isActive == 0 || $user->isActive == 1) &&
                                                            (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d')) &&
                                                            $user->hasComment == null

                                                            ? 'bg-primary text-white' : 'bg-light text-muted' }}">

                                                                <div class="d-flex justify-content-between">
                                                                    <small class="fw-bold">Approval of Requirements</small>
                                                                    <iconify-icon icon="uiw:d-arrow-right" width="22"></iconify-icon>
                                                                </div>
                                                            </div>
                                                            <div class="card-body text-center">
                                                                @if(($user->status == 1 || $user->status == 2 || $user->status == 4) && ($user->isActive == 0 || $user->isActive == 1) && (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d')))
                                                                <small class="fw-bold">{{ date('M d, Y', strtotime($user->signatureDate)) }}</small>
                                                               
                                                                <br>
                                                                <small class=""><span style="font-size: 12px">Status:</span> <span class="badge bg-success">Done</span></small>
                                                                <br>
                                                                <small style="font-size: 12px">Your requirements is approved. Please visit the office for the payment</small>
                                                                @else
                                                                -
                                                                <br>
                                                                <small class=""><span style="font-size: 12px">Status:</span> <span class="badge bg-warning">Processing</span></small>
                                                                @endif
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                        
                                                
                                        
                                                    <!-- Track 3 (Disabled) -->
                                                    <div class="col-md-3">
                                                        <div class="card mb-3 {{ 
                                                            
                                                            ($user->status == 1 || $user->status == 2 || $user->status == 4) && 
                                                            ($user->isActive == 0 || $user->isActive == 1)&&
                                                            (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d'))

                                                            ? 'border-primary' : 'border-secondary opacity-50' }}">

                                                            <div class="card-header p-3 {{ 

                                                            ($user->status == 1 || $user->status == 2 || $user->status == 4) && 
                                                            ($user->isActive == 0 || $user->isActive == 1) &&
                                                            (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d'))
                                                            
                                                            ? 'bg-primary text-white' : 'bg-light text-muted' }}">

                                                                <div class="d-flex justify-content-between">
                                                                    <small class="fw-bold">Payment & Signature</small>
                                                                    <iconify-icon icon="uiw:d-arrow-right" width="22"></iconify-icon>
                                                                </div>
                                                            </div>
                                                            <div class="card-body text-center">
                                                                @if($user->status == 2 && ($user->isActive == 0 || $user->isActive == 1) && (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d')))
                                                                <small class="fw-bold">{{ date('M d, Y', strtotime($user->releaseDate)) }}</small>
                                                               
                                                                <br>
                                                                <small class=""><span style="font-size: 12px">Status:</span> <span class="badge bg-success">Done</span></small>
                                                                <br>
                                                                <small style="font-size: 12px">Your franchise is ready for release. Please visit the office to claim it.</small>
                                                                @else
                                                                -
                                                                <br>
                                                                <small class=""><span style="font-size: 12px">Status:</span> <span class="badge bg-warning">Processing</span></small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                        
                                                   
                                        
                                                    <!-- Track 4 (Disabled) -->
                                                    <div class="col-md-3">
                                                        <div class="card mb-3 {{ $user->status == 2 && $user->isActive == 1 ? 'border-primary' : 'border-secondary opacity-50' }}">
                                                            <div class="card-header p-3 {{ $user->status == 2 && $user->isActive == 1 ? 'bg-primary text-white' : 'bg-light text-muted' }}">
                                                                <div class="d-flex justify-content-between">
                                                                    <small class="fw-bold">Release</small>
                                                                    <iconify-icon icon="game-icons:check-mark" width="22"></iconify-icon>
                                                                </div>
                                                            </div>
                                                            <div class="card-body text-center">
                                                                @if($user->status == 2 && ($user->isActive == 0 || $user->isActive == 1) && (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d')))
                                                                <small class="fw-bold">{{ date('M d, Y', strtotime($user->releaseDate)) }}</small>
                                                               
                                                                <br>
                                                                <small class=""><span style="font-size: 12px">Status:</span> <span class="badge bg-success">Done</span></small>
                                                                <br>
                                                                <small style="font-size: 12px">Valid until: </small><br>
                                                                <small class="fw-bold text-danger">{{ date('F d, Y', strtotime($user->expiresOn)) }}</small>
                                                                @else
                                                                -
                                                                <br>
                                                                <small class=""><span style="font-size: 12px">Status:</span> <span class="badge bg-warning">Processing</span></small>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                        
                                                   
                                        
                                                   
                                                </div>
                                            
                                        </div>
                                        


                                        <div class="col-md-12">
                                            <div>

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
                                                            $daysRemaining = $expiresOn->diff($today)->format('%a') + 1;
        
                                                            if ($daysRemaining < 0) {
                                                                $daysRemaining = 0;
                                                            }
        
                                                            $percentageRemaining = ($daysRemaining / $totalDaysInYear) * 100;
                                                        } else {
                                                            $percentageRemaining = 0;
                                                        }
                                                    }
                                                @endphp
                                                
                                                @if($daysRemaining <= 90 && $daysRemaining >= 1)

                                                <center>
                                                    <div class="toast fade show mt-4" role="alert" aria-live="assertive" data-bs-autohide="false" aria-atomic="true">
                                                        <div class="toast-header">
                                                            <img src="{{ asset('storage/logo/logo-sogod.gif') }}" alt="" class="me-2" height="18">
                                                            <strong class="me-auto">IMPORTANT NOTICE</strong>
                                                            <small class="text-muted"><iconify-icon icon="emojione:warning" width="24"></iconify-icon></small>
                                                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                                        </div>
                                                        <div class="toast-body text-start">
                                                            Your franchise will expire in <b class="text-danger">{{ $daysRemaining }} days</b>. Please prepare to renew immediately after expiration to maintain uninterrupted service and stay in compliance with local regulations. For assistance with the renewal process, feel free to contact our office.                                                        </div>
                                                    </div>
                                                </center>

                                                @endif

                                                <div id="chart-radialBar" class="mb-4"
                                                    data-colors='["#556ee6", "#34c38f", "#f46a6a"]'></div>
        
                                                <!-- the script will execute the radial chart to represent the remaining days of validity of the franchise -->
        
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
        
                                                <!-- this will determine the status of the franchise application -->
        
                                                <div class="text-center mt-4">
                                                    <p class="text-muted">Status:
                                                        @if ($user->isActive == 1)
                                                            <span class="text-success fw-bold">Valid</span>
                                                        @endif
                                                        @if ($user->isActive == 0)
                                                            @if ($user->hasComment == 1)
                                                                <span class="text-danger fw-bold">Application/Renewal Rejected</span>
                                                                
                                                                <div>
                                                                    <small class="text-primary">Comment/Reason: </small>
                                                                <div class="mb-4">
                                                                    {{ $user->comment }}
                                                                </div>
                                                                <a wire:navigate href="{{ route('user.edit-application', ['id' => $aes->encrypt($user->id)]) }}" class="btn btn-primary btn-sm">Edit Application</a>
                                                                </div>
                                                            @else
                                                                @if ($user->status == 0)
                                                                    <span class="text-danger fw-bold">Pending Application</span>
                                                                @endif
                                                                @if ($user->status == 1)
                                                                    <span class="text-primary fw-bold">For Payment & Signature/s</span>
                                                                @endif
                                                                @if ($user->status == 2)
                                                                    <span class="text-danger fw-bold">Expired</span>
                                                                @endif
                                                                @if ($user->status == 3)
                                                                    <span class="text-danger fw-bold">Pending Renewal</span>
                                                                @endif
                                                                @if ($user->status == 4)
                                                                    <span class="text-primary fw-bold">For Payment & Signature/s</span>
                                                                @endif
                                                            @endif
                                                            
                                                        @endif

                                                        @if($user->status == 2 && ($user->isActive == 0 || $user->isActive == 1) && (date('Y-m-d', strtotime($user->created_at->addYear())) > date('Y-m-d')))
                                                        <div class="text-center">
                                                            <a wire:navigate href="{{ route('user.upload-forms', ['id' => $aes->encrypt($user->id)]) }}" class="btn btn-success btn-sm shadow-lg align-items-center" style="font-size: 12px">
                                                                <iconify-icon icon="uim:upload-alt"></iconify-icon> Upload Forms <small>(with signatures)</small>
                                                            </a>
                                                        </div>
                                                        @endif

                                                    </p>
                                                    @if ($user->status == 2)
                                                        @if ($user->isActive == 0)
                                                            <button href="javascript:;" class="btn btn-success btn-sm shadow-lg"
                                                                id="renew-franchise">Renew Franchise</button>
                                                        @endif
                                                    @endif
                                                    @if ($user->status == 2)
                                                        @if ($user->isActive == 1)
                                                            <center>
                                                                <button href="javascript:;" class="btn btn-primary btn-sm shadow-lg mb-1 d-flex align-items-center" style="font-size: 12px"
                                                                    id="download-qrcode" data-id="{{ $user->applicant }}">
                                                                    <iconify-icon icon="uil:qrcode-scan" class="me-1"></iconify-icon>
                                                                    Download QRCode
                                                                </button>
                                                            </center>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <hr class="mb-0 mt-2">
                                                </div>
                                                <div class="col-md-3"></div>
                                            </div>

                                            <!-- in this area, it will display the current applicant for this franchise -->

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
                                                    <span class="text-muted">Renewed/Applied on: </span>
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
