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
                                <h5>Reset Password</h5>
                                <p class="text-muted">Create your new password</p>
                            </div>
                            <div class="p-2 mt-4">

                                
                                <form id="submit-new-password">
    
                                    <input type="hidden" value="{{ $id }}" name="id" class="form-control">
                                    <input type="hidden" value="{{ $resetID }}" name="resetID" class="form-control">

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


                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Reset Password</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Remember It ? <a wire:navigate href="{{ route('login') }}" class="fw-medium text-primary"> Sign in </a></p>
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

