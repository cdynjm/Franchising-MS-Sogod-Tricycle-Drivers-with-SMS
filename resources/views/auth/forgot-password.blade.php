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
                                <h5>Forgot Password</h5>
                                <p class="text-muted">Account Credentials</p>
                            </div>
                            <div class="p-2 mt-4">

                                <div class="alert alert-success text-center small mb-4" role="alert">
                                    Enter your username and registered contact number, an instructions will be sent to you!
                                </div>

                                <form id="reset-password">
    
                                    <div class="mb-3">
                                        <label class="form-label" for="useremail">Username</label>
                                        <div class="position-relative input-custom-icon">
                                            <input type="text" class="form-control" name="username" placeholder="Enter Username" required>  
                                            <span class="bx bx-mail-send"></span>
                                        </div>     
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="useremail">Contact Number</label>
                                        <div class="position-relative input-custom-icon">
                                            <input type="text" class="form-control" name="contactNumber" placeholder="Enter Contact Number" required>  
                                            <span class="bx bxs-contact"></span>
                                        </div>     
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Send OTP</button>
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

