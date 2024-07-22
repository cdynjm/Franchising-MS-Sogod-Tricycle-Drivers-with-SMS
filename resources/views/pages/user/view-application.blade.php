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

                                </div>
                                <div class="card-body">
                                    <input type="hidden" class="form-control text-uppercase"
                                        value="{{ $aes->encrypt($application->id) }}" name="id" readonly>
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
                                                <label for="" style="font-size: 13px;" class="text-uppercase">PLATE
                                                    NO.</label>
                                                <input type="text" class="form-control text-uppercase"
                                                    value="{{ $application->plateNumber }}" name="plateNumber" readonly>
                                            </div>
                                            @if ($application->caseNumber != null)
                                                <div class="mb-3">
                                                    <label for="" style="font-size: 13px;"
                                                        class="text-uppercase">CASE NO.</label>
                                                    <input type="text" class="form-control text-uppercase"
                                                        value="{{ $application->caseNumber }}" name="plateNumber" readonly>
                                                </div>
                                            @endif
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
