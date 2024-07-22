@extends('app')

@section('content')
        <div id="layout-wrapper">
            @include('layouts.navbar', ['page' => '<i class="bx bx-home-alt me-2"></i> Renew Franchise'])
            @include('layouts.sidebar')
            @include('layouts.horizontal-topbar')

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Franchise Renewal</h4>
                            </div><!-- end card header -->
                            <div class="card-body">
        
                                <div class="processing alert p-1 alert-sm alert-success align-items-center" style="display: none">
                                    <span class="me-2">
                                        <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
                                    </span>
                                    <div class="text-secondary" style="font-size: 13px;">Loading...</div>
                                </div>
        
                                <form action="" id="submit-renewal">
                                    <ul class="wizard-nav mb-5">
                                        <li class="wizard-list-item">
                                            <div class="list-item">
                                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Instructions and Details">
                                                    <i class="bx bx-file"></i>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="wizard-list-item">
                                            <div class="list-item">
                                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Seller Details">
                                                    <i class="bx bx-user-circle"></i>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="wizard-list-item">
                                            <div class="list-item">
                                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Bank Details">
                                                    <i class="bx bx-edit"></i>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <!-- wizard-nav -->
                                
                                    
                                    <div class="wizard-tab">
                                        <div>
                                            <div class="text-center mb-4">
                                                <h5>Instructions and Details</h5>
                                                <p class="card-title-desc text-danger">Please do READ before proceeding</p>
                                            </div>
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6>Franchise Application for Sogod, Southern Leyte Tricycles</h6>
                                                        <p style="font-size: 13px;">
                                                            A franchise application for tricycles in Sogod, Southern Leyte, is a formal process by which individuals or groups can obtain the necessary permits and licenses to operate tricycles as public transportation. This application ensures that all operators meet the local government's safety and regulatory standards, providing a reliable and secure transportation service to the community. The process involves submitting required documents, paying applicable fees, and undergoing inspections to comply with local ordinances and regulations.
                                                        </p>
                                                        <h6>Notice Regarding Data Privacy Act of 2012</h6>
                                                        <p style="font-size: 13px;">
                                                            In compliance with the Data Privacy Act of 2012, we are committed to safeguarding your personal information. Any data collected during the application process will be handled with the utmost confidentiality and used solely for legitimate purposes. We ensure that appropriate security measures are in place to protect your information from unauthorized access, and you have the right to access, correct, or request the deletion of your personal data at any time.
                                                        </p>
        
                                                        <input type="checkbox" id="agreeCheckbox">
                                                        <label for="agreeCheckbox">I agree to the terms and conditions</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                
                                    <div class="wizard-tab">
                                        <div class="text-center mb-4">
                                            <h5>Account Details</h5>
                                            <p class="card-title-desc">Fill all information below</p>
                                        </div>
                                        <div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;">Applicant Name</label>
                                                        <input type="text" class="form-control text-uppercase" name="applicant">
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;">Address</label>
                                                        <input type="text" class="form-control text-uppercase" name="address">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;">Contact Number</label>
                                                        <input type="text" class="form-control text-uppercase" name="contactNumber">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    @if($unit == 0)
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;" class="text-uppercase">MAKE (NAME OF UNIT)</label>
                                                        <input type="text" class="form-control text-uppercase"  name="make">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;" class="text-uppercase">MOTOR NO.</label>
                                                        <input type="text" class="form-control text-uppercase" name="motorNumber">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;" class="text-uppercase">CHASSIS NO.</label>
                                                        <input type="text" class="form-control text-uppercase" name="chassisNumber">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;" class="text-uppercase">PLATE NO.</label>
                                                        <input type="text" class="form-control text-uppercase" name="plateNumber">
                                                    </div>
                                                    @endif
                                                    @if($unit == 1)
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;" class="text-uppercase">MAKE (NAME OF UNIT)</label>
                                                        <input type="text" class="form-control text-uppercase" value="{{ $previousFranchise->make }}"  name="make" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;" class="text-uppercase">MOTOR NO.</label>
                                                        <input type="text" class="form-control text-uppercase" value="{{ $previousFranchise->motorNumber }}" name="motorNumber" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;" class="text-uppercase">CHASSIS NO.</label>
                                                        <input type="text" class="form-control text-uppercase" value="{{ $previousFranchise->chassisNumber }}" name="chassisNumber" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;" class="text-uppercase">PLATE NO.</label>
                                                        <input type="text" class="form-control text-uppercase" value="{{ $previousFranchise->plateNumber }}" name="plateNumber" readonly>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="wizard-tab">
                                        <div>
                                            <div class="text-center mb-4">
                                                <h5>Paper Requirements</h5>
                                                <p class="text-danger">Please ensure you upload clear photos of your certifications and documents. Blurry images may result in the rejection of your application</p>
                                            </div>
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div>
                                                            <b>Proof of Citizenship</b>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="" style="font-size: 13px;">Valid ID</label>
                                                            <input type="file" name="validID" class="form-control" accept=".jpg, .png, .jpeg, .webp">
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <b>TODA Clearance Certification</b>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="" style="font-size: 13px;">Front or 1st Page</label>
                                                            <input type="file" name="clearanceFront" class="form-control" accept=".jpg, .png, .jpeg, .webp">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="" style="font-size: 13px;">Back or 2nd Page</label>
                                                            <input type="file" name="clearanceBack" class="form-control" accept=".jpg, .png, .jpeg, .webp">
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <b>Receipt & Certification</b>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="" style="font-size: 13px;">Official Receipt (OR)</label>
                                                            <input type="file" name="officialReceipt" class="form-control" accept=".jpg, .png, .jpeg, .webp">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="" style="font-size: 13px;">Certificate of Registration (CR)</label>
                                                            <input type="file" name="certificate" class="form-control" accept=".jpg, .png, .jpeg, .webp">
                                                        </div>
                                                        <hr class="d-md-none">
                                                    </div>
        
                                                    <div class="col-md-6">
                                                        <div>
                                                            <b>Drivers Identification Card</b>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="" style="font-size: 13px;">Front</label>
                                                            <input type="file" name="cardFront" class="form-control" accept=".jpg, .png, .jpeg, .webp">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="" style="font-size: 13px;">Back</label>
                                                            <input type="file" name="cardBack" class="form-control" accept=".jpg, .png, .jpeg, .webp"> 
                                                        </div>
                                                        <hr>
                                                        
                                                    </div>
                                
                                                    
                                                </div><!-- end row -->
                                            </div><!-- end form -->
                                        </div>
                                    </div>
                                    <!-- wizard-tab -->
                                
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-primary w-sm" id="prevBtn" onclick="nextPrevRenew(-1)">Previous</button>
                                        <button type="button" class="btn btn-primary w-sm ms-auto" id="nextBtn" onclick="nextPrevRenew(1)">Next</button>
                                        
                                    </div>
                                </form>
                                
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