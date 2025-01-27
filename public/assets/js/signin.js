$(document).on("click", '#show-password', function(){

    var passwordInput = $('#password');
    var passwordIcon = $(this).find('i');

    if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text');
        passwordIcon.removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
    } else {
        passwordInput.attr('type', 'password');
        passwordIcon.removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
    }
});

var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-sm btn-primary',
        cancelButton: 'btn btn-sm btn-secondary ms-2'
    },
    buttonsStyling: false
});

$(document).on('submit', "#sign-in", function(e){
    e.preventDefault();
    var email = $('#email').val();
    var password = $('#password').val();
    if(email == '' || password == '') {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Empty Field(s)</h4><small>Do not leave an empty field</small>`,
            confirmButtonColor: "#3a57e8"
        });
        return false;
    }

    SweetAlert.fire({
        icon: 'info',
        html: `<h4 class="mb-0">Authenticating</h4><small>Please Wait...</small>`,
        allowOutsideClick: false,
        showConfirmButton: false
    });

    setTimeout(() => {
        const formData = new FormData(this);

        async function APIrequest() {
            return await axios.post('/authenticate', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
        }

        APIrequest().then(response => {
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            let errorMessage = 'An unknown error occurred';
            if (error.response && error.response.data && error.response.data.Message) {
                errorMessage = error.response.data.Message;

                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Failed</h4><small>${errorMessage}</small>`,
                    confirmButtonColor: "#3a57e8"
                });

            } else if (error.response && error.response.statusText) {
                errorMessage = error.response.statusText;
            }
        });
    }, 2000);

});

$(document).on('submit', "#reset-password", function(e){
    e.preventDefault();

    SweetAlert.fire({
        icon: 'info',
        html: `<h4 class="mb-0">Sending OTP</h4><small>Please Wait...</small>`,
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading(); // Show the loading indicator
        }
    });

    setTimeout(() => {
        const formData = new FormData(this);
        async function APIrequest() {
            return await axios.post('/api/send-otp', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $('.processing').removeClass('d-flex');
            
            SweetAlert.fire({
                icon: 'success',
                html: `
                <h4 class="mb-0">Done</h4><small>${response.data.Message}</small>
                    <div class="mt-4">
                        <a wire:navigate class="btn btn-sm rounded-1 btn-primary shadow-lg me-2" href="/confirm-OTP/${response.data.id}">Proceed</a>
                    </div>
                `,
                allowOutsideClick: false,
                showConfirmButton: false
            });
        })
        .catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>${error.response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('submit', "#confirm-OTP", function(e){
    e.preventDefault();

    SweetAlert.fire({
        icon: 'info',
        html: `<h4 class="mb-0">Verifying</h4><small>Please Wait...</small>`,
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading(); // Show the loading indicator
        }
    });

    setTimeout(() => {
        const formData = new FormData(this);
        async function APIrequest() {
            return await axios.post('/api/verify-otp', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $('.processing').removeClass('d-flex');
            
            SweetAlert.fire({
                icon: 'success',
                html: `
                <h4 class="mb-0">Done</h4><small>${response.data.Message}</small>
                    <div class="mt-4">
                        <a wire:navigate class="btn btn-sm rounded-1 btn-primary shadow-lg me-2" href="/reset-password/${response.data.id}">Proceed</a>
                    </div>
                `,
                allowOutsideClick: false,
                showConfirmButton: false
            });
        })
        .catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>${error.response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('submit', "#submit-new-password", function(e) {
    e.preventDefault();

    var password = document.getElementById("password").value.trim();
    var retypePassword = document.getElementById("retype-password").value.trim();

    // Strong password regex
    var strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_!@#$%^&*])[A-Za-z\d_!@#$%^&*]{8,}$/;

        // Check if passwords match
        if (password !== retypePassword) {
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Password Mismatch</h4><small>Please ensure the passwords match.</small>`,
                confirmButtonColor: "#3a57e8"
            });
            return false;
        }

        // Check for strong password
        if (!strongPasswordRegex.test(password)) {
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Weak Password</h4>
                       <small>Password must be at least 8 characters long, contain uppercase, lowercase, a number, and a special character.</small>`,
                confirmButtonColor: "#3a57e8"
            });
            return false;
        }

        SweetAlert.fire({
            icon: 'info',
            html: `<h4 class="mb-0">Processing</h4><small>Please Wait...</small>`,
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading(); // Show the loading indicator
            }
        });

    setTimeout(() => {
        const formData = new FormData(this);
        async function APIrequest() {
            return await axios.post('/api/reset-password', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
        }
        APIrequest().then(response => {
           

            SweetAlert.fire({
                icon: 'success',
                html: `
                <h4 class="mb-0">Done</h4>
                <small>${response.data.Message}</small>
                <div class="mt-4">
                    <a wire:navigate class="btn btn-sm btn-primary" href="/login">Log In</a>
                </div>`,
                confirmButtonColor: "#3a57e8",
                allowOutsideClick: false,
                showConfirmButton: false
            });
        })
        .catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>${error.response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});