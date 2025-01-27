@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.admin.data-analytics-category')
@extends('app')

@section('content')
    <div id="layout-wrapper">
        @include('layouts.navbar', ['page' => '<div class="d-flex align-items-center"><iconify-icon icon="flat-color-icons:doughnut-chart" width="24" height="24" class="me-2"></iconify-icon> Dashboard</div>'])
        @include('layouts.sidebar')
        @include('layouts.horizontal-topbar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- counts all the numbers of category members -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <h6 class="ms-1">Categories</h6>
                            <hr style="opacity: 0.1">
                            <div class="row">
                                @foreach ($categories as $cat)
                                <div class="col-md-12">
                                    <a wire:navigate href="{{ route('admin.view-category', ['id' => $aes->encrypt($cat->id)]) }}?{{ \Str::random(20) }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="font-size-15 m-0"><b>{{ $cat->category }}</b> | {{ $cat->color }}</p>
                                                       
                                                        <h4 class="mt-1 pt-1 mb-0 font-size-22">
                                                            {{ $cat->users_count }}
                                                            <span class="text-secondary fw-medium font-size-14 align-items-center d-inline-flex">
                                                                <iconify-icon icon="ic:twotone-info" width="17" height="17" class="me-1 mb-1"></iconify-icon>
                                                                <small class="">More Info</small>
                                                            </span>
                                                            
                                                        </h4>
                                                    </div>
                                                    <div class="">
                                                        <div class="avatar">
                                                            <div class="avatar-title rounded bg-transparent">
                                                            <iconify-icon icon="fluent:vehicle-motorcycle-28-filled" style="color: #00bcd4" width="40" height="40"></iconify-icon>
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

                        <!-- data analytics chart will be rendered here based on the script below -->

                        <div class="col-md-9">
                           
                            <form action="" id="generate-report">
                                <div class="row mb-3">
                                    <div class="col-md-3 mb-2">
                                        <select name="category" id="" class="form-select" required>
                                            <option value="">Select Category...</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $aes->encrypt($cat->id) }}">{{ $cat->category }} - {{ $cat->color }} | {{ $cat->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Year Dropdown -->
                                    <div class="col-md-3 mb-2">
                                        <select name="year" class="form-select" required>
                                            <option value="">Select Year...</option>
                                            @php
                                                $startYear = 2019;
                                                $currentYear = date("Y");
                                            @endphp
                                            @for ($year = $startYear; $year <= $currentYear; $year++)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                            
                                    <!-- Month Dropdown -->
                                    <div class="col-md-3 mb-2">
                                        <select name="month" class="form-select">
                                            <option value="">Select Month...</option>
                                            @php
                                                $months = [
                                                    "January", "February", "March", "April", "May", "June",
                                                    "July", "August", "September", "October", "November", "December"
                                                ];
                                            @endphp
                                            @foreach ($months as $index => $month)
                                                <option value="{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            
                                    <!-- Download Button -->
                                    <div class="col-md-3 mb-2 d-flex align-items-center">
                                        <!-- Toggle Switch -->
                                        <div class="form-check form-switch form-switch-md me-2">
                                            <input type="checkbox" class="form-check-input" id="printAll" name="printAll">
                                            <label class="form-check-label" for="printAll">
                                                <small>All</small>
                                            </label>
                                        </div>
                                        <!-- Generate Report Button -->
                                        <button class="btn btn-primary btn-sm ms-2 d-flex align-items-center">
                                            <iconify-icon icon="mingcute:download-fill" class="me-1"></iconify-icon> <small>Generate Report</small>
                                        </button>
                                    </div>
                                    
                                </div>
                            </form>                            

                            <div class="card">
                                
                                <div class="card-body pb-0">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                <iconify-icon icon="material-symbols-light:overview-rounded" style="color: #00bcd4" width="24" height="24" class="me-2"></iconify-icon>
                                                    <small class="text-secondary">Overview</small>
                                                </div>
                                                <!-- Legend -->
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex align-items-center me-2">
                                                        <div style="width: 16px; height: 16px; background-color: #0080FF; margin-right: 5px; border-radius: 5px"></div>
                                                        <small style="font-size: 13px">Valid</small>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div style="width: 16px; height: 16px; background-color: #FF0000; margin-right: 5px; border-radius: 5px"></div>
                                                        <small style="font-size: 13px">Invalid</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="d-lg-none d-md-none d-sm-block text-success mt-3" style="font-size: 13px">Press the shades to display data</p>
                                        </h5>
                                    </div>
                        
                                    <div class="row">
                                        @foreach ($categories as $cat)
                                            <div class="col-md-4 mb-4">
                                                <p class="text-dark">{{ $cat->category }} - {{ $cat->color }}</p>
                                                <div id="chart-{{ $cat->id }}"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <!-- data analytics for active and inactive franchises -->

                
                    <script>
                        @foreach ($categories as $cat)
                            @php
                                $activeCount = $cat->active_franchises_count;
                                $inactiveCount = $cat->expired_franchises_count;
                                $totalCount = $cat->users_count;
                    
                                $active = $totalCount != 0 ? ($activeCount / $totalCount) * 100 : 0;
                                $inactive = $totalCount != 0 ? ($inactiveCount / $totalCount) * 100 : 0;
                            @endphp
                    
                            // Define chart options
                            var options = {
                                series: [{{ number_format($active, 1) }}, {{ number_format($inactive, 1) }}],
                                chart: {
                                    height: 390,
                                    type: 'radialBar',
                                    animations: {
                                        enabled: true,
                                        easing: 'easeinout',
                                        speed: 1000
                                    },
                                    events: {

                                        dataPointSelection: function(event, chartContext, config) {
                                            const categoryId = {{ $cat->id }};
                                            
                                            // Check config.series[config.dataPointIndex] to get the value clicked
                                            let statusId = config.dataPointIndex === 0 ? 0 : 1;

                                            // Show SweetAlert for loading data
                                            Swal.fire({
                                                title: 'Retrieving Data...',
                                                text: 'Please wait while we fetch the data.',
                                                icon: 'info',
                                                showConfirmButton: false,
                                                willOpen: () => {
                                                    Swal.showLoading(); // Show the loading indicator
                                                }
                                            });

                                            // Get token from meta tag
                                            const token = $('meta[name="token"]').attr('content');

                                            // Send request to server to get data for this category
                                            axios.post('/api/get/data-analytics-users', {
                                                categoryID: categoryId,
                                                statusID: statusId
                                            }, {
                                                headers: {
                                                    "Authorization": "Bearer " + token
                                                }
                                            })
                                            .then(response => {
                                                // Close SweetAlert when data is fetched
                                                Swal.close();

                                                let tableContent = `
                                                
                                                <div class="mb-3">
                                                    <input type="text" id="search-input" class="form-control" placeholder="Search Data...">
                                                </div>
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-bordered text-nowrap" id="category-users-data-analytics" style="font-size: 13px">
                                                        <thead >
                                                            <tr>
                                                                <th style="background: #D9EDF8">Body Number</th>
                                                                <th style="background: #D9EDF8">Applicant</th>
                                                                <th style="background: #D9EDF8">Address</th>
                                                                <th style="background: #D9EDF8">${statusId === 0 ? 'Valid Until' : 'Expired On'}</th>
                                                                <th style="background: #D9EDF8" class="text-center">Days Left</th> <!-- New column for days left -->
                                                                <th style="background: #D9EDF8">Status</th> <!-- New column for status -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>`;

                                                response.data.users.forEach(user => {
                                                    // Handle case when expiresOn is null or missing
                                                    let expirationDate = user.expiresOn ? new Date(user.expiresOn) : null;
                                                    let formattedDate = expirationDate ? expirationDate.toLocaleDateString('en-US', {
                                                        year: 'numeric', // Full year
                                                        month: 'long',   // Full month name
                                                        day: 'numeric'   // Day of the month
                                                    }) : '-'; // If no expiration date, show '-'

                                                    // Calculate the number of days left if the expiration date exists
                                                    let daysLeft = '-';
                                                    if (expirationDate) {
                                                        let currentDate = new Date();
                                                        let timeDiff = expirationDate - currentDate;
                                                        daysLeft = Math.floor(timeDiff / (1000 * 3600 * 24)) + 1; // Convert milliseconds to days

                                                        // If the expiration date has already passed, show 0 or a negative value as "Expired"
                                                        if (daysLeft < 0) {
                                                            daysLeft = 0; // or show a custom message like "Expired"
                                                        }
                                                    }

                                                    // Determine status and apply respective classes based on user status and isActive values
                                                    let status = '';
                                                    let statusClass = ''; // Class for status color
                                                    let showExpiresOn = false; // Flag to control if "Expired On" should be displayed
                                                    let showDaysLeft = false;  // Flag to control if "Days Left" should be displayed
                                                    let showValidUntil = false; // Flag to control if "Valid Until" should be displayed

                                                    if (user.status === 0 && user.isActive === 0) {
                                                        status = 'Pending Application';
                                                        statusClass = 'text-danger'; // Red color for Pending Application
                                                    } else if (user.status === 1 && user.isActive === 0) {
                                                        status = 'For Payment & Signature';
                                                        statusClass = 'text-primary'; // Blue color for For Payment and Signature
                                                    } else if (user.status === 2 && user.isActive === 0) {
                                                        status = 'Expired';
                                                        statusClass = 'text-danger'; // Red color for Expired
                                                        showExpiresOn = true; // Show Expired On
                                                        showDaysLeft = true; // Show Days Left for Expired users
                                                    } else if (user.status === 3 && user.isActive === 0) {
                                                        status = 'Pending Renewal';
                                                        statusClass = 'text-danger'; // Red color for Pending Renewal
                                                    } else if (user.status === 4 && user.isActive === 0) {
                                                        status = 'For Payment & Signature';
                                                        statusClass = 'text-primary'; // Blue color for For Payment and Signature
                                                    } else if (user.status === 2 && user.isActive === 1) {
                                                        status = 'Valid';
                                                        statusClass = 'text-success'; // Green color for Valid
                                                        showValidUntil = true; // Show Valid Until for Valid users
                                                        showDaysLeft = true; // Show Days Left for Valid users
                                                    }

                                                    // Table row generation with conditional rendering of columns
                                                    tableContent += `<tr>
                                                        <td>${user.code}</td>
                                                        <td>${user.applicant}</td>
                                                        <td>${user.address}</td>`;

                                                    // Conditionally render "Expired On" or "Valid Until" based on status and isActive
                                                    if (showExpiresOn) {
                                                        tableContent += `<td class="text-danger">${formattedDate}</td>`; // Show Expired On for expired users
                                                    } else if (showValidUntil) {
                                                        tableContent += `<td class="text-danger">${formattedDate}</td>`; // Show Valid Until for valid users
                                                    } else {
                                                        tableContent += `<td>-</td>`; // Show '-' if neither expired nor valid
                                                    }

                                                    // Conditionally render "Days Left" for expired or valid users only
                                                    if (showDaysLeft) {
                                                        tableContent += `<td class="text-primary fw-bolder text-center" style="font-size: 18px">${daysLeft}</td>`;
                                                    } else {
                                                        tableContent += `<td class="text-center">-</td>`; // Show '-' if not expired or valid
                                                    }

                                                    // Status with dynamic color class
                                                    tableContent += `<td class="${statusClass}">${status}</td> <!-- Show the status with color class -->
                                                    </tr>`;
                                                });

                                                tableContent += `</tbody></table></div>`;

                                                // Show modal with response data
                                                showModal(
                                                    statusId === 0 ? "Valid Franchises" : "Invalid Franchises",
                                                    tableContent
                                                );
                                            })
                                            .catch(error => {
                                                // Close SweetAlert on error
                                                Swal.close();
                                                console.error("There was an error fetching the data:", error);
                                            });
                                        }
                                    }
                                },
                                plotOptions: {
                                    radialBar: {
                                        offsetY: 0,
                                        startAngle: -90,
                                        endAngle: 90,
                                        hollow: {
                                            margin: 5,
                                            size: '50%',
                                            background: 'transparent',
                                        },
                                        dataLabels: {
                                            name: {
                                                show: true,
                                                fontSize: '20px',
                                                fontWeight: 300,
                                                offsetY: 20,
                                            },
                                            value: {
                                                show: true,
                                                fontSize: '30px',
                                                fontWeight: 600,
                                                offsetY: -20,
                                                formatter: function(val) {
                                                    return val + "%";
                                                }
                                            },
                                            total: {
                                                show: true,
                                                label: 'Total',
                                                formatter: function(w) {
                                                    return "{{ $activeCount + $inactiveCount }}";
                                                }
                                            }
                                        }
                                    }
                                },
                                stroke: {
                                    colors: ['#fff'],
                                },
                                fill: {
                                    opacity: 0.8
                                },
                                labels: ['Valid: {{ $activeCount }}', 'Expired: {{ $inactiveCount }}'],
                                colors: ['#0080FF', '#FF0000'],
                            };
                    
                            // Render the chart
                            var chart = new ApexCharts(document.querySelector("#chart-{{ $cat->id }}"), options);
                            chart.render();
                        @endforeach
                    
                        // Show modal function to display data in table format
                        function showModal(title, content) {
                            document.getElementById("modal-title").innerText = title;
                            document.getElementById("modal-body").innerHTML = content;
                            new bootstrap.Modal(document.getElementById("infoModal")).show();
                        }
                    </script>

                    <style>
                        .class {
                            color: rgb(51, 81, 199)
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
