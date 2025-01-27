@php
    use App\Models\Franchise;
    // it will count new application and new franchise renewal and display it in the right side of menu page.
    $newApplication = Franchise::where(function($query) {
                $query->where('status', 0)
                      ->orWhere('status', 1);
            })
            ->whereNull('hasComment')
            ->count();
    $renewal = Franchise::where(function($query) {
                $query->where('status', 3)
                      ->orWhere('status', 4);
            })
            ->whereNull('hasComment')
            ->count();

@endphp

<style>

    .vertical-menu .metismenu li a {
        color: black;

        transition: background-color 0.3s, color 0.3s;

    }

    .vertical-menu .metismenu li.active a {
        color: #000;

        background-color: #e5f1f5;

    }
</style>

<div class="vertical-menu shadow-none border-none">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="javascript:;" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('storage/logo/logo-sogod.gif') }}" alt="" height="30">
            </span>
            <span class="logo-lg">
            <h1 class="align-items-center d-flex flex-column mt-4" href="javascript:;">
        <img style="width: 50px; height: 50px;" src="{{ asset('storage/logo/logo-sogod.gif') }}" class="mb-2 mt-2" alt="...">
        <span class="ms-3 fs-6 text-dark text-center">
            <span class="">Franchising MS</span>
            <p style="font-size: 11px;" class="text-secondary">Sogod Tricycle Drivers</p>
        </span>
    </h1>
            </span>

        </a>

    </div>

  <!--  <button type="button" class="btn btn-sm px-3 mt-2 font-size-24 header-item waves-effect vertical-menu-btn">
        <i class="bx bx-menu align-middle"></i>
    </button> -->

    <div data-simplebar class="sidebar-menu-scroll overflow-hidden">

        <!--- Sidemenu -->
        <div id="sidebar-menu" class="mt-5">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled mt-4" id="side-menu">
                <li class="menu-title ms-3" class="text-dark" data-key="t-menu"></li>
                @can('accessAdmin', Auth::user())
                <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active text-dark' : '' }}" class="d-flex align-items-center">
                    <a wire:navigate href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'bg-primary text-white' : '' }}">
                        <iconify-icon icon="flat-color-icons:doughnut-chart" style="color: #00bcd4; margin-left: 10px"  width="24" height="24"></iconify-icon>
                        <span class="menu-item">Dashboard</span>
                    </a>
                </li>

                    <li class="{{ Route::currentRouteName() == 'admin.categories' ? 'active text-dark' : '' }}" class="d-flex align-items-center">
                        <a wire:navigate href="{{ route('admin.categories') }}" class="{{ Route::currentRouteName() == 'admin.categories' ? 'bg-primary text-white' : '' }}">
                        <iconify-icon icon="tabler:category-filled" style="color: #00bcd4"  width="24" height="24" class="ms-2"></iconify-icon>
                            <span class="menu-item">Categories</span>
                        </a>
                    </li>

                    <li class="{{ Route::currentRouteName() == 'admin.renewal' ? 'active text-dark' : '' }}" class="d-flex align-items-center">
                        <a wire:navigate href="{{ route('admin.renewal') }}" class="{{ Route::currentRouteName() == 'admin.renewal' ? 'bg-primary text-white' : '' }}">
                        <iconify-icon icon="fluent-mdl2:renewal-current"  style="color: #00bcd4" width="24" height="24" class="ms-2"></iconify-icon>
                            <span class="menu-item">Renewal</span>
                            @if ($renewal != 0)
                                <span class="badge rounded-pill bg-danger">{{ $renewal }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="{{ Route::currentRouteName() == 'admin.new-application' ? 'active text-dark' : '' }}" class="d-flex align-items-center">
                        <a wire:navigate href="{{ route('admin.new-application') }}" class="{{ Route::currentRouteName() == 'admin.new-application' ? 'bg-primary text-white' : '' }}">
                        <iconify-icon icon="mingcute:file-fill" style="color: #00bcd4"width="24" height="24" class="ms-2"></iconify-icon>
                            <span class="menu-item">New Application</span>
                            @if ($newApplication != 0)
                                <span class="badge rounded-pill bg-danger">{{ $newApplication }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'admin.previous-data' ? 'active text-dark' : '' }}" class="d-flex align-items-center">
                        <a wire:navigate href="{{ route('admin.previous-data') }}" class="{{ Route::currentRouteName() == 'admin.previous-data' ? 'bg-primary text-white' : '' }}">
                        <iconify-icon icon="mage:file-records-fill" style="color: #00bcd4" width="24" height="24" class="ms-2"></iconify-icon>
                            <span class="menu-item">Previous Records</span>
                        </a>
                    </li>

                    <li class="">
                        <a href="javascript:void(0);" onclick="downloadIDCard()" class="d-flex align-items-center">
                            <iconify-icon icon="material-symbols:id-card" style="color: #00bcd4" width="24" height="24" class="ms-2"></iconify-icon>
                            <span class="menu-item mt-1">Download ID Card</span>
                        </a>
                    </li>
                    
                    <script>
                        function downloadIDCard() {
                            // Show SweetAlert with loading message
                            Swal.fire({
                                title: 'Downloading...',
                                text: 'Your download will start shortly.',
                                icon: 'info',
                                showConfirmButton: false,
                                didOpen: () => {
                                    // Start downloading the file
                                    // Create a temporary link to trigger download
                                    const link = document.createElement('a');
                                    link.href = '{{ asset("storage/Drivers-ID-Card-Format.pdf") }}';
                                    link.download = 'Drivers-ID-Card-Format.pdf';  // Optional: set a custom filename
                                    link.click();
                                }
                            });
                    
                            // Close the Swal after 2 seconds
                            setTimeout(() => {
                                Swal.close(); // Close the SweetAlert
                            }, 2000); // 2 seconds
                        }
                    </script>
                    

                    <li class="">
                        <a href="javascript:;" id="sign-out" download class="d-flex align-items-center">
                        <iconify-icon icon="material-symbols:logout" style="color: #00bcd4" width="24" height="24" class="ms-2"></iconify-icon>
                            <span class="menu-item mt-1">Logout</span>
                        </a>
                    </li>
                @endcan

                @can('accessUser', Auth::user())
                    <li class="{{ Route::currentRouteName() == 'user.dashboard' ? 'active text-dark' : '' }}" class="d-flex align-items-center">
                        <a wire:navigate href="{{ route('user.dashboard') }}" class="{{ Route::currentRouteName() == 'user.dashboard' ? 'bg-primary text-white' : '' }}">
                            <iconify-icon icon="flat-color-icons:doughnut-chart" width="24" height="24" class="ms-2"></iconify-icon>
                            <span class="menu-item">Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'user.renewal-history' ? 'active text-dark' : '' }}" class="d-flex align-items-center">
                        <a wire:navigate href="{{ route('user.renewal-history') }}" class="{{ Route::currentRouteName() == 'user.renewal-history' ? 'bg-primary text-white' : '' }}">
                            <iconify-icon icon="fluent-color:calendar-clock-24" width="24" height="24" class="ms-2"></iconify-icon>
                            <span class="menu-item">Renewal History</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="href="javascript:;" id="sign-out" download class="d-flex align-items-center">
                        <iconify-icon icon="material-symbols:logout" style="color: #00bcd4" width="24" height="24" class="ms-2"></iconify-icon>
                            <span class="menu-item mt-1">Logout</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>