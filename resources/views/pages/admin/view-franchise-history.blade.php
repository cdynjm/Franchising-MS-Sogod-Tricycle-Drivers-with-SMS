@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
        <div id="layout-wrapper">
            @include('layouts.navbar', ['page' => '<i class="bx bxs-category me-2"></i> View Franchise History'])
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
                                            <h6 class="text-sm">
                                                <button class="btn bg-warning fw-bold shadow-lg text-center">
                                                    {{ $account->categories->category }} - {{ sprintf('%03d', $account->name) }}
                                                </button>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        @livewire('view-franchise-history-data', ['accountID' => $aes->encrypt($account->id)])
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