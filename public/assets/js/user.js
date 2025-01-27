$(document).on('click', '#show-retype-profile-password', function () {
    const retypePasswordField = $('#retype-profile-password');
    const type = retypePasswordField.attr('type') === 'password' ? 'text' : 'password';
    retypePasswordField.attr('type', type);
    $(this).find('i').toggleClass('mdi-eye-outline mdi-eye-off-outline');
});

$(document).on('change', "#select-region", function(e){
    $('#select-province')
        .find('option')
        .remove()
        .end()
        .append('<option value="0">Retrieving, please wait...</option>');

    const data = { code: $(this).val() };
    async function APIrequest() {
        return await axios.post('/api/get-province', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        $("#select-province").html(response.data.Province);
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('change', "#select-province", function(e){
    $('#select-municipal')
        .find('option')
        .remove()
        .end()
        .append('<option value="0">Retrieving, please wait...</option>');

    const data = { code: $(this).val() };
    async function APIrequest() {
        return await axios.post('/api/get-municipal', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        $("#select-municipal").html(response.data.Municipal);
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('change', "#select-municipal", function(e){
    $('#select-barangay')
        .find('option')
        .remove()
        .end()
        .append('<option value="0">Retrieving, please wait...</option>');

    const data = { code: $(this).val() };
    async function APIrequest() {
        return await axios.post('/api/get-barangay', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        $("#select-barangay").html(response.data.Barangay);
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

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

var DelAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-sm btn-danger',
        cancelButton: 'btn btn-sm btn-secondary ms-2'
    },
    buttonsStyling: false
});

var ConfirmAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-sm btn-primary',
        cancelButton: 'btn btn-sm btn-secondary ms-2'
    },
    buttonsStyling: false
});

$(document).on("click", '#profile', function(){
    var name = $(this).data('name');
    var email = $(this).data('email');

    $('#name').val(name);
    $('#email').val(email);

    $('#profile-modal').modal('show');
 });

 $(document).on('submit', "#update-profile", function(e){
    e.preventDefault();

    var password = document.getElementById("password").value.trim();
    var retypePassword = document.getElementById("retype-profile-password").value.trim();
    
    if (password !== "") {

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
    }

    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/user-profile', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $('.processing').removeClass('d-flex');
            $("#profile-modal").modal('hide');

            SweetAlert.fire({
                icon: 'success',
                html: `
                <h4 class="mb-0">Done</h4>
                <small>${response.data.Message}</small>

                <div class="mt-4">
                    <a wire:navigate class="btn btn-sm btn-primary" href="/">Close</a>
                </div>
                `,
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

$(document).on("click", '#renew-franchise', function(){
  
    SweetAlert.fire({
        icon: 'info',
        html: `
        <h4 class="mb-2">Renew Franchise</h4>
        <small>Selecting a Unit <b>IMPORTANT NOTICE</b></small>
        <ol style="font-size: 14px;" class="mt-3">
            <li class="mb-3">By selecting the <b>Existing Unit</b>, you are confirming that you will continue to use your current tricycle and motor for this body number without any changes.</li>
            <li>By selecting the <b>New Unit</b>, you are opting for a complete replacement, using a new tricycle and motor for this body number.</li>
        </ol>
        <div class="mt-4">
            <a wire:navigate class="btn rounded-1 btn-primary shadow-lg me-2" href="/user/renew-franchise/Z5txoj0MSAUlfZFnLCTiFpXwkxkXRNyAbnsoubOS0otpu7MWfXnK5wrjbEhKpjUSVFFfxZFjZVvVVFW3Ti6TJH8iW_ISx6w-dmhDdc_m_VxrJN2Ws9GZxozz2VcpLhBFD_QblTga1SmzENWLsCFGwQ:ISlAKCMqZiYlXjEyMzQ1Ng">Existing Unit</a>
            <a wire:navigate class="btn rounded-1  btn-success shadow-lg" href="/user/renew-franchise/q0CwLsWJBelHrDYiAuk-xgVVFtLpyPnkGPiDKIk7oC0HMfeSbTU8QnQ49oSI7FfEi1-oTPyckxEcbK4l5UbB3YstLUe1vDtwHWk8BcNl-Oa5qrYVSEd9gbUMifkKmRzZ6xOJqjpf4tXZcreBWVK5vQ:ISlAKCMqZiYlXjEyMzQ1Ng">New Unit</a>
        </div>
        `,
       
        allowOutsideClick: true,
        showConfirmButton: false
    });
});

$(document).on('submit', "#submit-renewal", function(e){
    e.preventDefault();

    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/submit-renewal', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
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
                        <a wire:navigate class="btn btn-sm rounded-1 btn-primary shadow-lg me-2" href="/user/dashboard">Return to Dashboard</a>
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
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/register';
                }
            });
        });
    }, 1500);
});

$(document).on('submit', "#resubmit-application", function(e){
    e.preventDefault();

    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/resubmit-application', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
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
                    <a wire:navigate class="btn btn-sm btn-primary" href="/">Close</a>
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

$(document).on('click', '#download-forms', function() {
    var id = $('input[name=id]').val();
    var name = $('input[name=applicant]').val();

    SweetAlert.fire({
        icon: 'info',
        html: `
        <h4 class="mb-0">Download Forms</h4>
        <small></small>
        
        <div class="downloading mt-4 mb-4 alert p-1 alert-sm alert-success align-items-center" style="display: none">
            <span class="me-2">
                <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
            </span>
            <div class="text-secondary" style="font-size: 13px;">Downloading...</div>
        </div>

        <div class="mt-2">
            <a href="javascript:;" data-id="${id}" data-name="${name}" id="download-application"><small><i class="fas fa-download me-2"></i> Application Form</small></a>
        </div>
        <center><hr class="m-2 w-50"></center>

        <div class="mt-2">
            <a href="javascript:;" data-id="${id}" data-name="${name}" id="download-permit"><small><i class="fas fa-download me-2"></i> Permit Form</small></a>
        </div>
        <center><hr class="m-2 w-50"></center>

        <div class="mt-2">
            <a href="javascript:;" data-id="${id}" data-name="${name}" id="download-confirmation"><small><i class="fas fa-download me-2"></i> Confirmation Form</small></a>
        </div>
        <center><hr class="m-2 w-50"></center>

        <div class="mt-2">
            <a href="javascript:;" data-id="${id}" data-name="${name}" id="download-provisional"><small><i class="fas fa-download me-2"></i> Provisional Form</small></a>
        </div>
        <center><hr class="m-2 w-50"></center>
        `,
        confirmButtonColor: "#3a57e8",
        allowOutsideClick: false,
    });
});

$(document).on('click', '#download-application', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    const formData = new FormData();
    formData.append('id', id);

    $('.downloading').show(100);
    $('.downloading').addClass('d-flex');

    axios.post('/user/application-form', formData, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    }).then(function(response) {
            var data = response.data;
            var tempDiv = $('<div></div>').html(data);

            var style = '<style>#form-content { font-size: 15px; }</style>';
            tempDiv.prepend(style);

            $('#content').append(tempDiv);

            html2pdf().from(tempDiv[0]).set({
                margin: 0.5,
                filename: name + '-application-form.pdf',
                html2canvas: { scale: 5 },
                jsPDF: { orientation: 'portrait', unit: 'in', format: 'legal' }
            }).save().then(function () {
                tempDiv.remove();
            });

            setTimeout(function() {
                $('.downloading').hide(100);
                $('.downloading').removeClass('d-flex');
            }, 3000);
        })
        .catch(function(error) {
            console.error('Error fetching the content:', error);
        });
});

$(document).on('click', '#download-permit', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    const formData = new FormData();
    formData.append('id', id);

    $('.downloading').show(100);
    $('.downloading').addClass('d-flex');

    axios.post('/user/permit-form', formData, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    }).then(function(response) {
            var data = response.data;
            var tempDiv = $('<div></div>').html(data);

            var style = '<style>#form-content { font-size: 15px; }</style>';
            tempDiv.prepend(style);

            $('#content').append(tempDiv);

            html2pdf().from(tempDiv[0]).set({
                margin: 0.5,
                filename: name + '-permit-form.pdf',
                html2canvas: { scale: 5 },
                jsPDF: { orientation: 'portrait', unit: 'in', format: 'legal' }
            }).save().then(function () {
                tempDiv.remove();
            });

            setTimeout(function() {
                $('.downloading').hide(100);
                $('.downloading').removeClass('d-flex');
            }, 3000);
        })
        .catch(function(error) {
            console.error('Error fetching the content:', error);
        });
});

$(document).on('click', '#download-confirmation', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    const formData = new FormData();
    formData.append('id', id);

    $('.downloading').show(100);
    $('.downloading').addClass('d-flex');

    axios.post('/user/confirmation-form', formData, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    }).then(function(response) {
            var data = response.data;
            var tempDiv = $('<div></div>').html(data);

            var style = '<style>#form-content { font-size: 15px; }</style>';
            tempDiv.prepend(style);

            $('#content').append(tempDiv);

            html2pdf().from(tempDiv[0]).set({
                margin: 0.5,
                filename: name + '-confirmation-form.pdf',
                html2canvas: { scale: 5 },
                jsPDF: { orientation: 'portrait', unit: 'in', format: 'legal' }
            }).save().then(function () {
                tempDiv.remove();
            });

            setTimeout(function() {
                $('.downloading').hide(100);
                $('.downloading').removeClass('d-flex');
            }, 3000);
        })
        .catch(function(error) {
            console.error('Error fetching the content:', error);
        });
});

$(document).on('click', '#download-provisional', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    const formData = new FormData();
    formData.append('id', id);

    $('.downloading').show(100);
    $('.downloading').addClass('d-flex');

    axios.post('/user/provisional-form', formData, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    }).then(function(response) {
            var data = response.data;
            var tempDiv = $('<div></div>').html(data);

            var style = '<style>#form-content { font-size: 15px; }</style>';
            tempDiv.prepend(style);

            $('#content').append(tempDiv);

            html2pdf().from(tempDiv[0]).set({
                margin: 0.5,
                filename: name + '-provisional-form.pdf',
                html2canvas: { scale: 5 },
                jsPDF: { orientation: 'portrait', unit: 'in', format: 'legal' }
            }).save().then(function () {
                tempDiv.remove();
            });

            setTimeout(function() {
                $('.downloading').hide(100);
                $('.downloading').removeClass('d-flex');
            }, 3000);
        })
        .catch(function(error) {
            console.error('Error fetching the content:', error);
        });
});

$(document).on('submit', "#upload-form-with-signature", function(e){
    e.preventDefault();
    var id = $(this).data('id');
    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        formData.append('id', id);
        async function APIrequest() {
            return await axios.post('/api/create/upload-form-with-signature', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
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
                    <a wire:navigate class="btn btn-sm btn-primary" href="/user/upload-forms/${id}">Close</a>
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
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/register';
                }
            });
        });
    }, 1500);
});

$(document).on('click', "#collapse-display-for-papers", function(e) {
    e.preventDefault();
    var cardBody = $("#paper-requirements-content");
    var button = $(this);

    // Toggle the card body visibility with a callback function
    cardBody.slideToggle(100, function() {
        // After toggle is complete, update button text and icon
        if (cardBody.is(":visible")) {
            button.html('<iconify-icon icon="majesticons:arrows-collapse-full-line" width="20" class="me-1"></iconify-icon> Collapse');
        } else {
            button.html('<iconify-icon icon="flowbite:expand-outline" width="20" class="me-1"></iconify-icon> Expand');
        }
    });
});

$(document).on('click', "#collapse-display-for-forms", function(e) {
    e.preventDefault();
    var cardBody = $("#forms-content");
    var button = $(this);

    // Toggle the card body visibility with a callback function
    cardBody.slideToggle(100, function() {
        // After toggle is complete, update button text and icon
        if (cardBody.is(":visible")) {
            button.html('<iconify-icon icon="majesticons:arrows-collapse-full-line" width="20" class="me-1"></iconify-icon> Collapse');
        } else {
            button.html('<iconify-icon icon="flowbite:expand-outline" width="20" class="me-1"></iconify-icon> Expand');
        }
    });
});

$(document).on('click', '#download-qrcode', function() {
    var name = $(this).data('id');
    const formData = new FormData();
    formData.append('QRCODE', 'QRCODE');

    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Downloading...',
        allowOutsideClick: false,
        showConfirmButton: false
    });

    axios.post('/user/download-QRCode', formData, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    }).then(function(response) {
            var data = response.data;
            var tempDiv = $('<div></div>').html(data);

            var style = '<style>#qr-content { font-size: 15px; }</style>';
            tempDiv.prepend(style);

            $('#qr-content').append(tempDiv);

            html2pdf().from(tempDiv[0]).set({
                margin: 0.5,
                filename: name + '-QRCode.pdf',
                html2canvas: { scale: 5 },
                jsPDF: { orientation: 'portrait', unit: 'in', format: 'letter' }
            }).save().then(function () {
                tempDiv.remove();
            });

            setTimeout(function() {
                SweetAlert.close();
            }, 2000);
        })
        .catch(function(error) {
            console.error('Error fetching the content:', error);
        });
});