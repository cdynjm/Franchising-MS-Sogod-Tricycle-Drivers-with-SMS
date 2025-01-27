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
        <div class="d-flex flex-column min-vh-100 px-3 pt-4">
            <div class="row justify-content-center my-auto">
                <div class="col-md-8 col-lg-6 col-xl-5">

                    <div class="mb-4 pb-2 flex-column align-items-center text-center">
                        <a href="" class="d-block auth-logo mb-2">
                            <img src="{{ asset('storage/logo/logo.png') }}" alt="Sogod Logo" height="70" class="auth-logo-dark">
                        </a>
                        <h5 class="modal-title" id="loginModalLabel">Franchising Management System</h5>
                    </div>

                    <div class="card">
                        <div class="card-body p-4"> 
                            <div class="text-center mt-2">
                                <h5>OTP Verification</h5>
                            </div>
                            <div class="p-2 mt-4">

                                <div class="alert alert-success text-center small mb-4" role="alert">
                                    Please Enter your OTP
                                </div>

                                <form id="confirm-OTP">
    
                                    <input type="hidden" value="{{ $id }}" name="id" class="form-control">
                                    <input type="hidden" value="{{ $resetID }}" name="resetID" class="form-control">

                                    <div class="mb-3">
                                        <label class="form-label" for="otp">OTP</label>
                                        <div class="position-relative input-custom-icon">
                                            <input type="text" class="form-control" name="otp" placeholder="Enter OTP">  
                                            <span class="bx bx-mail-send"></span>
                                        </div>     
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Reset</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <p class="mb-0"><a wire:navigate href="{{ route('login') }}" class="fw-medium text-primary"> Back to Sign in </a></p>
                                    </div>
                                </form>
                            </div>
        
                        </div>
                    </div>

                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center p-4">
                    </div>
                </div>
            </div>

        </div>
    </div><!-- end container -->
</div>

@endsection

