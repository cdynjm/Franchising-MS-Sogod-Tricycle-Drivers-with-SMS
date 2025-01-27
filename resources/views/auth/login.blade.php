@extends('app')

@section('content')
<div class="authentication-bg min-vh-100" style="background-image: url('{{ asset('storage/logo/tricycle-image.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container-fluid d-flex flex-column min-vh-100">

        <!-- Right Center Text Section -->
        <div class="d-flex justify-content-end align-items-center flex-grow-1">
            <div class="position-relative text-white text-center text-md-end mx-4 px-4" style="background-color: rgba(0, 123, 255, 0.56); padding: 100px; padding-bottom: 30px; border-radius: 20px;">
                <h1 class="display-4 fw-bold animate__animated animate__fadeInUp text-white">Tricycle Drivers Information</h1>
                <h3 class="display-6 lead mb-4 animate__animated animate__fadeInUp text-white" style="animation-delay: 0.3s;">& Franchising Management System</h3>
                <hr class="" style="border-top: 2px solid white; margin: auto;">
                <p class="mt-2">Municipality of Sogod Southern Leyte</p>
            </div>
        </div>

       
        

        <!-- Top-right Login and Register Buttons -->
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-2">
            <a href="#" class="btn btn-sm btn-primary me-2 shadow-lg" data-bs-toggle="modal" data-bs-target="#loginModal">
                Login
            </a>
            <a wire:navigate href="{{ route('register') }}" class="btn btn-sm btn-success shadow-lg">
                Register
            </a>
        </div>
        
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header with Logo -->
            <div class="modal-header flex-column align-items-center">
                <a href="" class="d-block auth-logo mb-2">
                    <img src="{{ asset('storage/logo/logo.png') }}" alt="Sogod Logo" height="70" class="auth-logo-dark">
                </a>
                <h5 class="modal-title" id="loginModalLabel">Franchising Management System</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body with Login Form -->
            <div class="modal-body">
                <p class="text-muted text-center">Sign in with your credentials to continue</p>

                <!-- Error Alert -->
                @if (!empty(Session::get('error')))
                    <div class="alert alert-danger text-xs">
                        {{ Session::get('error') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form id="sign-in">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="username" style=" margin-bottom: 10px;">Username</label>
                        <div class="position-relative input-custom-icon">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter username">
                            <span class="bx bx-user"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password-input" style=" display: block; margin-bottom: 10px;">Password</label>
                        <div class="position-relative auth-pass-inputgroup input-custom-icon">
                            <span class="bx bx-lock-alt"></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="show-password">
                                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button class="btn btn-primary w-100 waves-effect waves-light shadow-lg" type="submit">Log In</button>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="fw-medium text-primary" wire:navigate> Apply Here. </a></p>
                    </div>

                    <div class="mt-2 text-center">
                        <p class="mb-0">Forgot Password? <a href="{{ route('forgot-password') }}" class="fw-medium text-primary" wire:navigate> Reset Here. </a></p>
                    </div>
                </form>
            </div>

            <!-- Guest Footer -->
            <div class="text-center">
                @include('layouts.footer-guest')
            </div>
        </div>
    </div>
</div>

<style>
    /* Main background image */
    .authentication-bg {
        background-image: url('{{ asset('storage/logo/tricycle-image.jpg') }}');
        background-size: cover;
        background-position: center;
    }

    /* Modal background */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Animations for titles */
    .animate__animated {
        animation-duration: 1s;
    }

    .animate__fadeInUp {
        animation-name: fadeInUp;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 30px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    /* Mobile view adjustments */
    @media (max-width: 767px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .authentication-bg {
            background-size: cover;
            background-position: center;
        }

        .position-absolute {
            top: 10px;
            right: 10px;
        }
    }
</style>
@endsection
