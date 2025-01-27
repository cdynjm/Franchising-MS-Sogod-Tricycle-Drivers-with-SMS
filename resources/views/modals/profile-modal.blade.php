<div class="modal fade" id="profile-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">

        <!-- this modal updates the account information of both admin and user -->

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="update-profile">
                <div class="modal-body">

                    <div class="processing alert p-1 alert-sm alert-success align-items-center" style="display: none">
                        <span class="me-2">
                            <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
                        </span>
                        <div class="text-secondary" style="font-size: 13px;">Loading...</div>
                    </div>


                    <div class="mb-3">
                        <label class="mb-2" for="">Name</label>
                        @if (Auth::user()->role == 2)
                            <p class="text-danger m-0 mb-2"><small>Name cannot be changed due to information security
                                    purposes</small></p>
                        @endif
                        <div class="position-relative input-custom-icon">
                            <input type="text" class="form-control" id="name" name="name" placeholder=""
                                @if (Auth::user()->role == 1) required @endif
                                @if (Auth::user()->role == 2) disabled @endif>
                            <span class="bx bx-user"></span>
                        </div>
                    </div>

                    <div class="mb-3">

                        <label class="mb-2" for="">Account Username</label>
                        @if (Auth::user()->role == 2)
                            <p class="text-danger m-0 mb-2"><small>Username cannot be changed due to information
                                    security purposes</small></p>
                        @endif
                        <div class="position-relative input-custom-icon">
                            <input type="email" class="form-control" id="email" name="email" placeholder=""
                                @if (Auth::user()->role == 1) required @endif
                                @if (Auth::user()->role == 2) disabled @endif>
                            <span class="bx bx-envelope"></span>
                        </div>
                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="password-input">Change Password</label>
                        <div class="position-relative auth-pass-inputgroup input-custom-icon">
                            <span class="bx bx-lock-alt"></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="">
                            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0"
                                id="show-password">
                                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">

                        <label class="form-label" for="password-input">Re-Type Password</label>
                        <div class="position-relative auth-pass-inputgroup input-custom-icon">
                            <span class="bx bx-lock-alt"></span>
                            <input type="password" class="form-control" id="retype-profile-password" name="retype-password" placeholder="">
                            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0"
                                id="show-retype-profile-password">
                                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="" class="btn btn-sm btn-primary waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
