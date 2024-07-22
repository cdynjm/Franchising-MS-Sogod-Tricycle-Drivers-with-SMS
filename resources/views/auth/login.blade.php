@extends('app')

@section('content')
    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="mb-4 pb-2">
                            <a href="index.html" class="d-block auth-logo">
                                <img src="{{ asset('storage/logo/logo.png') }}" alt="" height="70"
                                    class="auth-logo-dark me-start">
                                <img src="{{ asset('storage/logo/logo.png') }}" alt="" height="70"
                                    class="auth-logo-light me-start">
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5>Franchising Management System</h5>
                                    <p class="text-muted">Sign in with your credentials to continue</p>
                                </div>
                                <div class="p-2 mt-4">

                                    @if (!empty(Session::get('error')))
                                        <div class="alert alert-danger text-xs">
                                            {{ Session::get('error') }}
                                        </div>
                                    @endif

                                    <form id="sign-in">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <div class="position-relative input-custom-icon">
                                                <input type="text" class="form-control" id="email" name="email"
                                                    placeholder="Enter username">
                                                <span class="bx bx-user"></span>
                                            </div>
                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                                <span class="bx bx-lock-alt"></span>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Enter password">
                                                <button type="button"
                                                    class="btn btn-link position-absolute h-100 end-0 top-0"
                                                    id="show-password">
                                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type="submit">Log In</button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Don't have an account? <a wire:navigate
                                                    href="{{ route('register') }}" class="fw-medium text-primary"> Apply
                                                    Here. </a> </p>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                @include('layouts.footer-guest')

            </div>
        </div><!-- end container -->
    </div>
@endsection
