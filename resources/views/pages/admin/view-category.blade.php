@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
        <div id="layout-wrapper">
            @include('layouts.navbar', ['page' => '<i class="bx bxs-category me-2"></i> View Category'])
            @include('layouts.sidebar')
            @include('layouts.horizontal-topbar')

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                               <div class="card mt-4 rounded-1">
                                <div class="card-header">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h6 class="text-sm">Category {{ $category->category }} - {{ $category->color }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        @include('data.admin.view-category-data')
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