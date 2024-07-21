<header id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="javascript:;" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('storage/logo/logo-sogod.gif') }}" alt="" class="m-0" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('storage/logo/logo-sogod.gif') }}" alt="" height="40">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="/assets/images/logo-light.png" alt="" height="30">
                    </span>
                    <span class="logo-sm">
                        <img src="/assets/images/logo-light-sm.png" alt="" height="26">
                    </span>
                </a>
            </div>
          
            <button type="button" class="btn btn-sm font-size-24 header-item waves-effect vertical-menu-btn">
                <i class="bx bx-menu align-middle"></i> <h6 class="d-lg-none d-sm-block">FMS</h6>
            </button>

            <!-- start page title -->
            <div class="page-title-box align-self-center d-none d-md-block">
                <p class="fw-bold mt-3">{!! $page !!}</p>
            </div>
            <!-- end page title -->

        </div>

        <div class="d-flex">

            

          
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown-v"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-bell icon-sm align-middle"></i>
                    <span class="noti-dot bg-danger rounded-pill">4</span>
                </button>
                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown-v">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-15"> Notifications </h5>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small fw-semibold text-decoration-underline"> Mark all as read</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 250px;">
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted font-size-13 mb-0 float-end">1 hour ago</p>
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div>
                                        <p class="mb-0">It will seem like simplified English.</p>
                                    </div>
                                </div>
                    
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-18">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted font-size-13 mb-0 float-end">3 min ago</p>
                                    <h6 class="mb-1">Your order is placed</h6>
                                    <div>
                                        <p class="mb-0">If several languages coalesce the grammar</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-18">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted font-size-13 mb-0 float-end">8 min ago</p>
                                    <h6 class="mb-1">Your item is shipped</h6>
                                    <div>
                                        <p class="mb-0">If several languages coalesce the grammar</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="assets/images/users/avatar-6.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted font-size-13 mb-0 float-end">1 hour ago</p>
                                    <h6 class="mb-1">Salena Layfield</h6>
                                    <div>
                                        <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                            <i class="uil-arrow-circle-right me-1"></i> <span>View More..</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown-v"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('storage/icons/profile.png') }}"
                    alt="Header Avatar">
                    @if(Auth::user()->role == 1)
                    <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">{{ Auth::user()->name }}</span>
                    @endif
                    @if(Auth::user()->role == 2)
                    <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">{{ Auth::user()->email }} {{ ucwords(Auth::user()->categories->color) }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="p-3 border-bottom">
                        @if(Auth::user()->role == 1)
                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                        <p class="mb-0 font-size-11 text-muted">{{ Auth::user()->email }}</p>
                        @endif
                        @if(Auth::user()->role == 2)
                        <h6 class="mb-0">{{ Auth::user()->email }} {{ ucwords(Auth::user()->categories->color) }}</h6>
                        <p class="mb-0 font-size-11 text-muted">{{ Auth::user()->email }}</p>
                        @endif
                    </div>
                    <a class="dropdown-item" href="contacts-profile.html"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Profile</span></a>
                    <a class="dropdown-item" href="javascript:;" id="sign-out"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Logout</span></a>
                </div>
            </div>
        </div>
    </div>
</header>