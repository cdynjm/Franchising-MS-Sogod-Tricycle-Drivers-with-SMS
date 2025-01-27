@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div id="layout-wrapper">
        @include('layouts.navbar', ['page' => '<div class="d-flex align-items-center"><iconify-icon icon="flat-color-icons:doughnut-chart" width="24" height="24" class="me-2"></iconify-icon> Edit Application</div>'])
        @include('layouts.sidebar')
        @include('layouts.horizontal-topbar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- this displays the remaining days of validity of the franchise. -->

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card mt-4 rounded-1">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    
                                    <h6 class="text-sm">Edit Application</h6>

                                </div>
                                <div class="card-body">

                                <div class="processing alert p-1 alert-sm alert-success align-items-center"
                                    style="display: none">
                                    <span class="me-2">
                                        <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
                                    </span>
                                    <div class="text-secondary" style="font-size: 13px;">Loading...</div>
                                </div>

                                <form id="resubmit-application">
                                    <div class="alert alert-warning">
                                        <small class="fw-bold">Comment/Reason: </small>
                                        <p class="mb-2">
                                            {{ $application->comment }}
                                        </p>
                                        <hr>
                                        <p class="mb-1">Please Apply all the required changes indicated above.</p>
                                    </div>

                                    <input type="hidden" class="form-control text-uppercase"
                                        value="{{ $aes->encrypt($application->id) }}" name="id" readonly>
                                    <input type="hidden" class="form-control text-uppercase"
                                        value="{{ $application->User->name }}" name="bodyNumber" readonly>
                                        
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;">Applicant Name</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->applicant }}" name="applicant" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;">Address</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->address }}" name="address" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;">Contact Number</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    name="contactNumber" value="{{ $application->contactNumber }}" required>
                                            </div>
                                            <div class="mb-3">
                                            <label for="" style="font-size: 13px;">Unit/Tricycle
                                                Category/Route</label>
                                                <select name="category" id="category" class="form-select">
                                                    <option value="">Select...</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $aes->encrypt($cat->id) }}" data-value="{{ $cat->category }}" @selected($application->user->category == $cat->id)>
                                                            {{ $cat->category }} - {{ $cat->color }} | {{ $cat->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;" class="text-uppercase">MAKE
                                                    (NAME OF UNIT)</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->make }}" name="make" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;" class="text-uppercase">MOTOR
                                                    NO.</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->motorNumber }}" name="motorNumber" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;"
                                                    class="text-uppercase">CHASSIS NO.</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->chassisNumber }}" name="chassisNumber"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;" class="text-uppercase">PLATE
                                                    NO.</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->plateNumber }}" name="plateNumber" required>
                                            </div>
                                            @if ($application->caseNumber != null)
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">CASE NO.</label>
                                                    <input type="text" class="form-control text-uppercase"
                                                        value="{{ $application->caseNumber }}" name="plateNumber" >
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if (
                                            $application->validIDcheck == 1 ||
                                            $application->todaCheck == 1 ||
                                            $application->driverCheck == 1 ||
                                            $application->ORCheck == 1 ||
                                            $application->CRCheck == 1
                                        )
                                          <div class="col-md-12">
                                            <div class="text-center mb-4">
                                                <h5>Paper Requirements</h5>
                                                <p class="text-danger">Please ensure that you upload clear photos of your certifications and documents. Blurry images may result in your application being rejected again. The document requirements listed below were not identified correctly, so please re-upload them.</p>
                                            </div>
                                            <div>
                                                
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            @if($application->validIDcheck == 1)
                                                            <div>
                                                                <b>Proof of Citizenship</b>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" style="font-size: 13px;">Valid
                                                                    ID</label>
                                                                <input type="file" name="validID" id="validID"
                                                                    class="form-control" accept=".jpg" required>
                                                            </div>
                                                            <hr>
                                                            @endif
                                                            @if($application->todaCheck == 1)
                                                            <div>
                                                                <b>TODA Clearance Certification</b>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" style="font-size: 13px;">Clearance</label>
                                                                <input type="file" name="clearanceFront"
                                                                    id="clearanceFront" class="form-control"
                                                                    accept=".jpg" required>
                                                            </div>
                                                          <!--  <div class="mb-4">
                                                                <label for="" style="font-size: 13px;">Back or 2nd
                                                                    Page</label>
                                                                <input type="file" name="clearanceBack" id="clearanceBack"
                                                                    class="form-control" accept=".jpg" required>
                                                            </div> -->
                                                            <hr>
                                                            @endif
                                                            
                                                            @if($application->ORCheck == 1 || $application->CRCheck)
                                                            <div>
                                                                <b>Receipt & Certification</b>
                                                            </div>
                                                            @endif
                                                            @if($application->ORCheck == 1)
                                                            <div class="mb-3">
                                                                <label for="" style="font-size: 13px;">Official
                                                                    Receipt (OR)</label>
                                                                <input type="file" name="officialReceipt"
                                                                    id="officialReceipt" class="form-control"
                                                                    accept=".jpg" required>
                                                            </div>
                                                            @endif
                                                            @if($application->CRCheck == 1)
                                                            <div class="mb-4">
                                                                <label for="" style="font-size: 13px;">Certificate of
                                                                    Registration (CR)</label>
                                                                <input type="file" name="certificate" id="certificate"
                                                                    class="form-control" accept=".jpg" required>
                                                            </div>
                                                            <hr class="d-md-none">
                                                            @endif
                                                        </div>
    
                                                        @if($application->driverCheck == 1)
                                                        <div class="col-md-6">
                                                            <div>
                                                                <b>Drivers Identification Card</b>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" style="font-size: 13px;">Front</label>
                                                                <input type="file" name="cardFront" id="cardFront"
                                                                    class="form-control" accept=".jpg" required>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="" style="font-size: 13px;">Back</label>
                                                                <input type="file" name="cardBack" id="cardBack"
                                                                    class="form-control" accept=".jpg" required>
                                                            </div>
                                                        @endif
                                                        </div>
    
                                                    </div><!-- end row -->

                                                    <button class="btn btn-success btn-sm shadow-sm">Resubmit</button>
                                                
                                            </div><!-- end form -->
                                        </div>  
                                        @endif
                                    </div>

                                    <!-- decreased the size of the image before uploading it to the server -->

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

                                        @if($application->validIDcheck == 1)
                                            document.querySelector('#validID'),
                                        @endif

                                        @if($application->todaCheck == 1)
                                            document.querySelector('#clearanceFront'),
                                            document.querySelector('#clearanceBack'),
                                        @endif

                                        @if($application->ORCheck == 1)
                                            document.querySelector('#officialReceipt'),
                                        @endif

                                        @if($application->CRCheck == 1)
                                            document.querySelector('#certificate'),
                                        @endif

                                        @if($application->driverCheck == 1)
                                            document.querySelector('#cardFront'),
                                            document.querySelector('#cardBack'),
                                        @endif
                                    ];

                                    fileInputs.forEach(input => {
                                        input.addEventListener('change', handleFileInputChange);
                                    });

                                }); 
                                    </script>
                                    

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
