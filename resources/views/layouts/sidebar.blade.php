@php
    use App\Models\Franchise;

    $newApplication = Franchise::where('status', 0)
            ->orWhere('status', 1)->count();
    $renewal = Franchise::where('status', 3)
            ->orWhere('status', 4)->count();

@endphp

<style>
    /* Default styles for the sidebar list items */
.vertical-menu .metismenu li a {
    color: black; /* Default text color */
    transition: background-color 0.3s, color 0.3s; /* Smooth transition for color changes */
}

/* Active state styles for the sidebar list items */
.vertical-menu .metismenu li.active a {
    color: #000; /* Active text color */
    background-color: #e5f1f5; /* Active background color */
}

</style>

<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="javascript:;" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('storage/logo/logo-sogod.gif') }}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <h1 class="align-items-center d-flex mt-3" href="javascript:;">
                    <img style="width: 50px; height: 50px;" src="{{ asset('storage/logo/logo-sogod.gif') }}" class="mb-4 mt-2" alt="...">
                    <span class="ms-3 fs-6 text-dark">
                        <span class="">Franchising MS</span>
                    <p style="font-size: 11px;" class="text-secondary">Sogod Tricycle Drivers</p>
                  </span>
                </h1>
            </span>
            
        </a>
  
        
    </div>
  
    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
        <i class="bx bx-menu align-middle"></i>
    </button>
  
    <div data-simplebar class="sidebar-menu-scroll">
  
  
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled mt-4" id="side-menu">
                <li class="menu-title" class="text-dark" data-key="t-menu">Pages</li>
                @if(Auth::user()->role == 1)
               <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active text-dark' : '' }}">
                    <a wire:navigate href="{{ route('admin.dashboard') }}">
                        <i class="bx bxs-home icon nav-icon"></i>
                        <span class="menu-item" >Dashboard</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() == 'admin.categories' ? 'active text-dark' : '' }}">
                    <a wire:navigate href="{{ route('admin.categories') }}">
                        <i class="bx bxs-category icon nav-icon"></i>
                        <span class="menu-item">Categories</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() == 'admin.renewal' ? 'active text-dark' : '' }}">
                    <a wire:navigate href="{{ route('admin.renewal') }}">
                        <i class="fas fa-redo-alt icon nav-icon"></i>
                        <span class="menu-item">Renewal</span>
                        @if($renewal != 0)
                        <span class="badge rounded-pill bg-danger">{{ $renewal }}</span>
                        @endif
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() == 'admin.new-application' ? 'active text-dark' : '' }}">
                    <a wire:navigate href="{{ route('admin.new-application') }}">
                        <i class="fas fa-folder fs-5 icon nav-icon"></i>
                        <span class="menu-item">New Application</span>
                        @if($newApplication != 0)
                        <span class="badge rounded-pill bg-danger">{{ $newApplication }}</span>
                        @endif
                    </a>
                </li>
                @endif

                @if(Auth::user()->role == 2)
               <li class="{{ Route::currentRouteName() == 'user.dashboard' ? 'active text-dark' : '' }}">
                    <a wire:navigate href="{{ route('user.dashboard') }}">
                        <i class="bx bxs-home icon nav-icon"></i>
                        <span class="menu-item" >Dashboard</span>
                    </a>
                </li>
                <li class="{{ Route::currentRouteName() == 'user.renewal-history' ? 'active text-dark' : '' }}">
                    <a wire:navigate href="{{ route('user.renewal-history') }}">
                        <i class="fas fa-redo-alt icon nav-icon"></i>
                        <span class="menu-item" >Renewal History</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
  </div>