@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">

            <!-- registration for new applications for franchise -->

            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-12">

                        <div class="mb-4 pb-2">
                            <a href="index.html" class="d-block auth-logo">
                                <img src="{{ asset('storage/logo/logo.png') }}" alt="" height="70"
                                    class="auth-logo-dark me-start">
                                <img src="{{ asset('storage/logo/logo.png') }}" alt="" height="70"
                                    class="auth-logo-light me-start">
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Franchise Application</h4>
                            </div><!-- end card header -->
                            <div class="card-body">

                                <div class="processing alert p-1 alert-sm alert-success align-items-center"
                                    style="display: none">
                                    <span class="me-2">
                                        <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
                                    </span>
                                    <div class="text-secondary" style="font-size: 13px;">Loading...</div>
                                </div>

                                <form action="" id="submit-application">
                                    <ul class="wizard-nav mb-5">
                                        <li class="wizard-list-item">
                                            <div class="list-item">
                                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    >
                                                    <i class="bx bx-file"></i>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="wizard-list-item">
                                            <div class="list-item">
                                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    >
                                                    <i class="bx bx-user-circle"></i>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="wizard-list-item">
                                            <div class="list-item">
                                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    >
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
                                                        <h6>Important Instructions for Tricycle Franchise Application</h6>
                                                        <p style="font-size: 13px;">
                                                            If your tricycle's body number is already registered in our
                                                            system, please do not attempt to register it again. Duplicate
                                                            registrations will not be accepted and may cause delays in your
                                                            application process. Instead, please log in to your existing
                                                            account to update your information or manage your franchise
                                                            details. If you encounter any issues or need assistance, contact
                                                            our support team for help.
                                                        </p>
                                                        <h6>Franchise Application for Sogod, Southern Leyte Tricycles</h6>
                                                        <p style="font-size: 13px;">
                                                            A franchise application for tricycles in Sogod, Southern Leyte,
                                                            is a formal process by which individuals or groups can obtain
                                                            the necessary permits and licenses to operate tricycles as
                                                            public transportation. This application ensures that all
                                                            operators meet the local government's safety and regulatory
                                                            standards, providing a reliable and secure transportation
                                                            service to the community. The process involves submitting
                                                            required documents, paying applicable fees, and undergoing
                                                            inspections to comply with local ordinances and regulations.
                                                        </p>
                                                        <h6>Notice Regarding Data Privacy Act of 2012</h6>
                                                        <p style="font-size: 13px;">
                                                            In compliance with the Data Privacy Act of 2012, we are
                                                            committed to safeguarding your personal information. Any data
                                                            collected during the application process will be handled with
                                                            the utmost confidentiality and used solely for legitimate
                                                            purposes. We ensure that appropriate security measures are in
                                                            place to protect your information from unauthorized access, and
                                                            you have the right to access, correct, or request the deletion
                                                            of your personal data at any time.
                                                        </p>

                                                        <input type="checkbox" id="agreeCheckbox">
                                                        <label for="agreeCheckbox">I agree to the terms and
                                                            conditions</label>
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
                                                
                                                    <div class="row mb-3">
                                                       
                                                        <div class="col-md-6">
                                                            <label for="" style="font-size: 13px;">Last
                                                                Name</label>
                                                            <input type="text" class="form-control text-uppercase"
                                                            name="lastname">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" style="font-size: 13px;">First
                                                                Name</label>
                                                            <input type="text" class="form-control text-uppercase"
                                                            name="firstname">
                                                        </div>
                                                      
                                                    </div>

                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="" style="font-size: 13px;">Middle Initial</label>
                                                            <input type="text" class="form-control text-uppercase"
                                                            name="middleinitial">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" style="font-size: 13px;">Body Number of your
                                                                Unit/Tricycle</label>
                                                            <input type="number" step="1" min="0" id="bodyNumber"
                                                                class="form-control" name="bodyNumber">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;">Unit/Tricycle
                                                            Category/Route</label>
                                                            <select name="category" id="category" class="form-select">
                                                                <option value="">Select...</option>
                                                                @foreach ($categories as $cat)
                                                                    <option value="{{ $aes->encrypt($cat->id) }}" data-value="{{ $cat->category }}">
                                                                        {{ $cat->category }} - {{ $cat->color }} | {{ $cat->description }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
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

                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;">Contact
                                                            Number</label>
                                                        <input type="text" class="form-control text-uppercase"
                                                            name="contactNumber">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;"
                                                            class="text-uppercase">MAKE (NAME OF UNIT)</label>
                                                        <input type="text" class="form-control text-uppercase"
                                                            name="make">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;"
                                                            class="text-uppercase">MOTOR NO.</label>
                                                        <input type="text" class="form-control text-uppercase"
                                                            name="motorNumber">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;"
                                                            class="text-uppercase">CHASSIS NO.</label>
                                                        <input type="text" class="form-control text-uppercase"
                                                            name="chassisNumber">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" style="font-size: 13px;"
                                                            class="text-uppercase">PLATE NO.</label>
                                                        <input type="text" class="form-control text-uppercase"
                                                            name="plateNumber">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wizard-tab">
                                        <div>
                                            <div class="text-center mb-4">
                                                <h5>Paper Requirements</h5>
                                                <p class="text-danger">Please ensure you upload clear photos of your
                                                    certifications and documents. Blurry images may result in the rejection
                                                    of your application</p>
                                            </div>
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div>
                                                            <b>Proof of Citizenship</b>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="" style="font-size: 13px;">Valid
                                                                ID</label>
                                                            <input type="file" name="validID" id="validID"
                                                                class="form-control" accept=".jpg">
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <b>TODA Clearance Certification</b>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="" style="font-size: 13px;">Clearance</label>
                                                            <input type="file" name="clearanceFront"
                                                                id="clearanceFront" class="form-control"
                                                                accept=".jpg">
                                                        </div>
                                                       <!-- <div class="mb-4">
                                                            <label for="" style="font-size: 13px;">Back or 2nd
                                                                Page</label>
                                                            <input type="file" name="clearanceBack" id="clearanceBack"
                                                                class="form-control" accept=".jpg">
                                                        </div> -->
                                                        <hr>
                                                        <div>
                                                            <b>Receipt & Certification</b>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="" style="font-size: 13px;">Official
                                                                Receipt (OR)</label>
                                                            <input type="file" name="officialReceipt"
                                                                id="officialReceipt" class="form-control"
                                                                accept=".jpg">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="" style="font-size: 13px;">Certificate of
                                                                Registration (CR)</label>
                                                            <input type="file" name="certificate" id="certificate"
                                                                class="form-control" accept=".jpg">
                                                        </div>
                                                        <hr class="d-md-none">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div>
                                                            <b>Drivers Identification Card</b>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="" style="font-size: 13px;">Front</label>
                                                            <input type="file" name="cardFront" id="cardFront"
                                                                class="form-control" accept=".jpg">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="" style="font-size: 13px;">Back</label>
                                                            <input type="file" name="cardBack" id="cardBack"
                                                                class="form-control" accept=".jpg">
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <b>Your Account Credentials</b>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="username"
                                                                style="font-size: 13px">Username</label>
                                                            <div class="position-relative input-custom-icon">
                                                                <input type="text"
                                                                    class="form-control fw-bolder text-primary"
                                                                    id="username" name="username"
                                                                    placeholder="Enter username" readonly>
                                                                <span class="bx bx-user"></span>
                                                            </div>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label class="form-label" for="password-input" style="font-size: 13px;">Password</label>
                                                            <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                                                <span class="bx bx-lock-alt"></span>
                                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                                                                <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="show-password">
                                                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-4">
                                                            <label class="form-label" for="retype-password-input" style="font-size: 13px;">Retype Password</label>
                                                            <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                                                <span class="bx bx-lock-alt"></span>
                                                                <input type="password" class="form-control" id="retype-password" name="retype-password" placeholder="Retype password">
                                                                <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="show-retype-password">
                                                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        
                                                        <div>
                                                            <small class="text-danger">Please take note of your
                                                                credentials, as they will serve as your account for this
                                                                BODY NUMBER to log in to the system for renewal
                                                                purposes</small>
                                                        </div>
                                                    </div>

                                                </div><!-- end row -->
                                            </div><!-- end form -->
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('livewire:navigated', () => { 
                                        const compressImage = async (file, {
                                            quality = 1,
                                            type = file.type
                                        }) => {

                                            const imageBitmap = await createImageBitmap(file);

                                            const canvas = document.createElement('canvas');
                                            canvas.width = imageBitmap.width;
                                            canvas.height = imageBitmap.height;
                                            const ctx = canvas.getContext('2d');
                                            ctx.drawImage(imageBitmap, 0, 0);

                                            const blob = await new Promise((resolve) =>
                                                canvas.toBlob(resolve, type, quality)
                                            );

                                            return new File([blob], file.name, {
                                                type: blob.type,
                                            });
                                        };

                                        const handleFileInputChange = async (e) => {
                                            const {
                                                files
                                            } = e.target;

                                            if (!files.length) return;

                                            const dataTransfer = new DataTransfer();

                                            for (const file of files) {

                                                if (!file.type.startsWith('image')) {

                                                    dataTransfer.items.add(file);
                                                    continue;
                                                }

                                                const compressedFile = await compressImage(file, {
                                                    quality: 0.3,
                                                    type: 'image/jpeg'
                                                });

                                                dataTransfer.items.add(compressedFile);
                                            }

                                            e.target.files = dataTransfer.files;
                                        };

                                        const fileInputs = [
                                            document.querySelector('#validID'),
                                            document.querySelector('#clearanceFront'),
                                            document.querySelector('#clearanceBack'),
                                            document.querySelector('#officialReceipt'),
                                            document.querySelector('#certificate'),
                                            document.querySelector('#cardFront'),
                                            document.querySelector('#cardBack')
                                        ];

                                        fileInputs.forEach(input => {
                                            input.addEventListener('change', handleFileInputChange);
                                        });
                                    });
                                    </script>

                                    <!-- wizard-tab -->

                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-primary w-sm" id="prevBtn"
                                            onclick="nextPrev(-1)">Previous</button>
                                        <button type="button" class="btn btn-primary w-sm ms-auto" id="nextBtn"
                                            onclick="nextPrev(1)">Next</button>

                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account? <a wire:navigate href="{{ route('login') }}"
                                    class="fw-medium text-primary"> Log in. </a> </p>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->

                @include('layouts.footer-guest')

            </div>

        </div>
    </div>
@endsection
