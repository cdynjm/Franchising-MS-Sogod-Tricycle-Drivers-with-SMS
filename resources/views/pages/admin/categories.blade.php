@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.admin.create.category-modal')
@extends('modals.admin.update.category-modal')

@extends('app')

@section('content')
    <div id="layout-wrapper">
        @include('layouts.navbar', ['page' => '<div class="d-flex align-items-center"><iconify-icon icon="tabler:category-filled" style="color: #00bcd4" width="24" height="24" class="me-2"></iconify-icon> Categories</div>'])
        @include('layouts.sidebar')
        @include('layouts.horizontal-topbar')

        <!-- list of all categories -->

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-4 rounded-1">
                                <div class="card-header">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h6 class="text-sm">List of Categories</h6>
                                        </div>
                                        <button class="btn btn-sm btn-primary shadow-lg text-white" id="add-category">+
                                            Add</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        @include('data.admin.category-data')
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
