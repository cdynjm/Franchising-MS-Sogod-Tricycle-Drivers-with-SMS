@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div id="layout-wrapper">
        @include('layouts.navbar', ['page' => '<div class="d-flex align-items-center"><iconify-icon icon="mage:file-records-fill" style="color: #00bcd4" width="24" height="24" class="me-2"></iconify-icon> Save Previous Records</div>'])
        @include('layouts.sidebar')
        @include('layouts.horizontal-topbar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- you can add here the previous records of franchise renewal -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-4 rounded-1">
                                <div class="card-header">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h6 class="text-sm">Save Previous Data Records
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="alert alert-warning" style="font-size: 14px">
                                        <strong>IMPORTANT NOTICE BEFORE SAVING PREVIOUS RECORDS:</strong> 
                                        If the body number of a tricycle is not yet registered in the database or does not have an account, please follow these steps to create a new account:
                                        <ol>
                                            <li><strong>Select Category:</strong> Choose the appropriate category for the tricycle.</li>
                                            <li><strong>Select User:</strong> After selecting the category, choose the user and then select <em>"No Account Yet (Create)"</em> to create a new account.</li>
                                            <li><strong>Check for Existing Registration:</strong>
                                                <ul>
                                                    <li>If you believe the body number is already registered, you can verify this by selecting the category, then selecting the user, and searching for the registered number.</li>
                                                    <li>If the body number is found, it means the tricycle is already registered in the system.</li>
                                                </ul>
                                            </li>
                                        </ol>
                                        For smooth processing, always ensure you accurately select the category and user before proceeding.
                                    </div>

                                    <div class="processing alert p-1 alert-sm alert-success align-items-center" style="display: none">
                                        <span class="me-2">
                                            <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
                                        </span>
                                        <div class="text-secondary" style="font-size: 13px;">Loading...</div>
                                    </div>
                                    
                                    <form action="" id="create-previous-records">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="" class="ms-1" style="font-size: 13px">Category</label>
                                                <select name="category" id="selected-category" class="form-select mb-3" required>
                                                    <option value="">Select...</option>
                                                    @foreach ($category as $cat)
                                                        <option value="{{ $aes->encrypt($cat->id) }}" data-category="{{ $cat->category }}">{{ $cat->category }} - {{ $cat->color }} | {{ $cat->description }}</option>
                                                    @endforeach
                                                </select>
    
                                                @include('pages.admin.user-accounts')
    
                                                <div style="display: none" id="show-create-account" class="mt-3">
                                                    <label for="" class="ms-1" style="font-size: 13px">Body Number</label>
                                                    <input type="number" class="form-control mb-3" id="body-number" name="bodyNumber">
    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="username"
                                                            style="font-size: 13px">Username</label>
                                                        <div class="position-relative input-custom-icon">
                                                            <input type="text"
                                                                class="form-control fw-bolder text-primary"
                                                                id="prev-username" name="username"
                                                                placeholder="" readonly>
                                                            <span class="bx bx-user"></span>
                                                        </div>
                                                    </div>
    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="password-input"
                                                            style="font-size: 13px;">Password</label>
                                                        <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                                            <span class="bx bx-lock-alt"></span>
                                                            <input type="password" class="form-control"
                                                                id="prev-password" name="password"
                                                                placeholder="Enter password">
                                                            <button type="button"
                                                                class="btn btn-link position-absolute h-100 end-0 top-0"
                                                                id="show-password">
                                                                <i
                                                                    class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="retype-password-input" style="font-size: 13px;">Retype Password</label>
                                                        <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                                            <span class="bx bx-lock-alt"></span>
                                                            <input type="password" class="form-control" id="retype-password" placeholder="Retype password">
                                                            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="show-retype-password">
                                                                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
    
                                              
    
                                                <div class="row mb-3">
                                                       
                                                    <div class="col-md-6">
                                                        <label for="" style="font-size: 13px;">Last
                                                            Name</label>
                                                        <input type="text" class="form-control text-uppercase"
                                                        name="lastname" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" style="font-size: 13px;">First
                                                            Name</label>
                                                        <input type="text" class="form-control text-uppercase"
                                                        name="firstname" required>
                                                    </div>
                                                  
                                                </div>

                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="" style="font-size: 13px;">Middle Initial</label>
                                                        <input type="text" class="form-control text-uppercase"
                                                        name="middleinitial">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" style="font-size: 13px;">Contact Number</label>
                                                        <input type="text" class="form-control text-uppercase"
                                                            name="contactNumber" required>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="" style="font-size: 13px;">Region</label>
                                                        @include('auth.address.region')
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="" style="font-size: 13px;">Province</label>
                                                        @include('auth.address.province')
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" style="font-size: 13px;">Municipal</label>
                                                        @include('auth.address.municipal')
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" style="font-size: 13px;">Barangay</label>
                                                        @include('auth.address.barangay')
                                                    </div>
                                                </div>
                                              
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">MAKE (NAME OF UNIT)</label>
                                                    <input type="text" class="form-control text-uppercase"
                                                        name="make" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">MOTOR NO.</label>
                                                    <input type="text" class="form-control text-uppercase"
                                                        name="motorNumber" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">CHASSIS NO.</label>
                                                    <input type="text" class="form-control text-uppercase"
                                                        name="chassisNumber" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">PLATE NO.</label>
                                                    <input type="text" class="form-control text-uppercase"
                                                        name="plateNumber" required>
                                                </div>
    
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">MAYOR</label>
                                                    <input type="text" class="form-control text-uppercase"
                                                        name="mayor" required>
                                                </div>
    
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">POLICE</label>
                                                    <input type="text" class="form-control text-uppercase"
                                                        name="police" required>
                                                </div>
    
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">DATE OF RENEWAL</label>
                                                    <input type="date" class="form-control text-uppercase"
                                                        name="renew" required>
                                                </div>
    
                                                <div class="mb-4">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">DATE OF EXPIRATION <small class="text-primary">(auto-set based on renewal date)</small></label>
                                                    <input type="date" class="form-control text-uppercase"
                                                        name="expire" required>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-sm btn-primary d-flex align-items-center shadow-lg">
                                                    Save Records
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
