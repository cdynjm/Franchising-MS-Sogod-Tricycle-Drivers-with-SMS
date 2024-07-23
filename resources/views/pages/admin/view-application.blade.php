@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div id="layout-wrapper">
        @include('layouts.navbar', ['page' => '<i class="fas fa-folder me-2"></i> Application'])
        @include('layouts.sidebar')
        @include('layouts.horizontal-topbar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-4 rounded-1">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    @php
                                        $statusLabels = [
                                            0 => 'text-danger|Pending',
                                            1 => 'text-success|For Payment & Signature/s',
                                            2 => 'text-primary|Registered',
                                            3 => 'text-danger|Renewal',
                                            4 => 'text-success|For Payment & Signature/s',
                                            5 => 'text-danger|Expired',
                                        ];
                                        [$class, $label] = explode(
                                            '|',
                                            $statusLabels[$application->status] ?? 'text-muted|Unknown',
                                        );
                                    @endphp

                                    <h6 class="text-sm">Application - <span
                                            class="{{ $class }}">{{ $label }}</span></h6>
                                    <div class="btn-group">
                                        @if ($application->status == 0)
                                            <button class="btn btn-sm btn-success rounded-1 shadow-lg text-white me-2"
                                                id="confirm-application"><i class="fas fa-check me-1"></i> Confirm</button>
                                            <button class="btn btn-sm btn-danger rounded-1 shadow-lg text-white"
                                                id="reject-application"><i class="fas fa-times me-1"></i> Reject</button>
                                        @endif
                                        @if ($application->status == 3)
                                            <button class="btn btn-sm btn-success rounded-1 shadow-lg text-white me-2"
                                                id="confirm-renewal"><i class="fas fa-check me-1"></i> Confirm</button>
                                            <button class="btn btn-sm btn-danger rounded-1 shadow-lg text-white"
                                                id="reject-renewal"><i class="fas fa-times me-1"></i> Reject</button>
                                        @endif
                                        @if ($application->status == 1)
                                            <button class="btn btn-sm btn-primary rounded-1 shadow-lg text-white me-2"
                                                id="release-franchise"><i class="fas fa-check me-1"></i> Release</button>
                                            <button class="btn btn-sm btn-danger rounded-1 shadow-lg text-white me-2"
                                                id="download-forms"><i class="fas fa-folder me-1"></i> Forms</button>
                                        @endif
                                        @if ($application->status == 4)
                                            <button class="btn btn-sm btn-primary rounded-1 shadow-lg text-white me-2"
                                                id="renew-franchise"><i class="fas fa-check me-1"></i> Renew</button>
                                        @endif
                                        @if ($application->status == 2 || $application->status == 4 || $application->status == 5)
                                            <button class="btn btn-sm btn-danger rounded-1 shadow-lg text-white me-2"
                                                id="download-forms"><i class="fas fa-folder me-1"></i> Forms</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" class="form-control text-uppercase"
                                        value="{{ $aes->encrypt($application->id) }}" name="id" readonly>
                                    <input type="hidden" class="form-control text-uppercase"
                                        value="{{ $aes->encrypt($application->userID) }}" name="userID" readonly>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;">Applicant Name</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->applicant }}" name="applicant" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;">Body Number of your
                                                    Unit/Tricycle</label>
                                                <input type="number" step="1" min="0" id="bodyNumber"
                                                    value="{{ $application->user->name }}" class="form-control fw-bold"
                                                    name="bodyNumber" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;">Unit/Tricycle
                                                    Category/Route</label>
                                                <select name="category" id="category" class="form-select" disabled>
                                                    <option value="">Select...</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $aes->encrypt($cat->id) }}"
                                                            @selected($cat->id == $application->user->category)>{{ $cat->category }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;">Address</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->address }}" name="address" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;">Contact Number</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    name="contactNumber" value="{{ $application->contactNumber }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;" class="text-uppercase">MAKE
                                                    (NAME OF UNIT)</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->make }}" name="make" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;" class="text-uppercase">MOTOR
                                                    NO.</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->motorNumber }}" name="motorNumber" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;"
                                                    class="text-uppercase">CHASSIS NO.</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->chassisNumber }}" name="chassisNumber"
                                                    readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" style="font-size: 13px;"
                                                    class="text-uppercase">PLATE NO.</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->plateNumber }}" name="plateNumber" readonly>
                                            </div>
                                            @if ($application->caseNumber != null)
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">CASE NO.</label>
                                                    <input type="text" class="form-control text-uppercase"
                                                        value="{{ $application->caseNumber }}" name="plateNumber"
                                                        readonly>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            @if ($application->status != 2 && $application->status !== 5)
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Paper Requirements</h6>
                                    </div>
                                    <div class="card-body">

                                        <div id="loadingDiv"
                                            class="processing p-1 alert alert-sm alert-success align-items-center d-flex">
                                            <i class="mdi mdi-spin mdi-loading fs-3 me-2 ms-1"></i>
                                            <span class="text-secondary" style="font-size: 13px;">Loading Images...</span>
                                        </div>

                                        <script>
                                            document.addEventListener('livewire:navigated', function() {
                                                setTimeout(function() {
                                                    var loadingDiv = document.getElementById('loadingDiv');
                                                    if (loadingDiv) {
                                                        loadingDiv.style.display = 'none';
                                                        loadingDiv.classList.remove('d-flex');
                                                    }
                                                }, 2000);
                                            });
                                        </script>

                                        <div class="row text-center mt-4">
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <b>Proof of Citizenship</b>
                                                    <p class="mb-2">Valid ID</p>
                                                    <img src="{{ asset('storage/files/' . $application->validID) }}"
                                                        alt="" class="img-fluid rounded-2 shadow-lg">
                                                </div>
                                                <hr>
                                                <div class="mb-4">
                                                    <b>TODA Clearance Certification</b>
                                                    <p class="mb-2">Front or 1st Page</p>
                                                    <img src="{{ asset('storage/files/' . $application->clearanceFront) }}"
                                                        alt="" class="img-fluid rounded-2 shadow-lg">
                                                </div>
                                                <div class="mb-4">
                                                    <p class="mb-2">Back or 2nd Page</p>
                                                    <img src="{{ asset('storage/files/' . $application->clearanceBack) }}"
                                                        alt="" class="img-fluid rounded-2 shadow-lg">
                                                </div>
                                                <hr>
                                                <div class="mb-4">
                                                    <div class="mb-2 fw-bold">Official Receipt (OR)</div>
                                                    <img src="{{ asset('storage/files/' . $application->officialReceipt) }}"
                                                        alt="" class="img-fluid rounded-2 shadow-lg">
                                                </div>
                                                <hr class="d-lg-none d-sm-block">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <div class="mb-2 fw-bold">Certificate of Registration (CR)</div>
                                                    <img src="{{ asset('storage/files/' . $application->certificate) }}"
                                                        alt="" class="img-fluid rounded-2 shadow-lg">
                                                </div>
                                                <hr>
                                                <div class="mb-4">
                                                    <b>Drivers Identification Card</b>
                                                    <p class="mb-2">Front</p>
                                                    <img src="{{ asset('storage/files/' . $application->cardFront) }}"
                                                        alt="" class="img-fluid rounded-2 shadow-lg">
                                                </div>
                                                <div class="mb-4">
                                                    <p class="mb-2">Back</p>
                                                    <img src="{{ asset('storage/files/' . $application->cardBack) }}"
                                                        alt="" class="img-fluid rounded-2 shadow-lg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
