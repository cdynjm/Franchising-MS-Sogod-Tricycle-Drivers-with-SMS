
$(document).on('click', '#show-retype-password', function () {
    const retypePasswordField = $('#retype-password');
    const type = retypePasswordField.attr('type') === 'password' ? 'text' : 'password';
    retypePasswordField.attr('type', type);
    $(this).find('i').toggleClass('mdi-eye-outline mdi-eye-off-outline');
});

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

    var passwordInput = $('input[name=password');
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
            return await axios.post('/api/update/profile', formData, {
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

$(document).on("click", '#sms-token', function(){
    var token = $(this).data('token');
    var mobile = $(this).data('mobile');

    $('#token').val(token);
    $('#mobile').val(mobile);

    $('#sms-token-modal').modal('show');
 });

 $(document).on('submit', "#update-sms-token", function(e){
    e.preventDefault();

    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/sms-token', formData, {
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
            $("#sms-token-modal").modal('hide');

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

$(document).on("click", '#signature', function(){
    var mayor = $(this).data('mayor');
    var police = $(this).data('police');

    $('#mayor').val(mayor);
    $('#police').val(police);

    $('#signature-modal').modal('show');
 });

 $(document).on('submit', "#update-signature", function(e){
    e.preventDefault();

    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/signature', formData, {
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
            $("#signature-modal").modal('hide');

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

$(document).on("click", '#add-category', function(){
    $('input').val('');
   $('#create-category-modal').modal('show');
});

$(document).on('submit', "#create-category", function(e){
    e.preventDefault();

    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        async function APIrequest() {
            return await axios.post('/api/create/category', formData, {
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
            $("#create-category-modal").modal('hide');
            $('input').val('');
            $('#category-data').html(response.data.Category);

            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        })
        .catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on("click", '#edit-category', function(){

    var id = $(this).parents('tr').find('td[id]').attr("id");
    var category = $(this).parents('tr').find('td[category]').attr("category");
    var description = $(this).parents('tr').find('td[description]').attr("description");
    var color = $(this).parents('tr').find('td[color]').attr("color");

    $('input[name=id]').val(id);
    $('input[name=category]').val(category);
    $('input[name=description]').val(description);
    $('input[name=color]').val(color);

    $('#update-category-modal').modal('show');
 });

 $(document).on('submit', "#update-category", function(e){
    e.preventDefault();

    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/category', formData, {
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
            $("#update-category-modal").modal('hide');
            $('input').val('');
            $('#category-data').html(response.data.Category);

            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        })
        .catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('click', "#delete-category", function(e){
    DelAlert.fire({
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will remove the category permanently.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it!',
    })
    .then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            const data = {id: $(this).parents('tr').find('td[id]').attr("id")};
            async function APIrequest() {
                return await axios.delete('/api/delete/category', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $('#category-data').html(response.data.Category);
                SweetAlert.fire({
                    icon: 'success',
                    html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            })
            .catch(error => {
                console.error('Error:', error);
                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});

$(document).on('click', "#confirm-application", function(e){
    e.preventDefault();
    var id = $('input[name=id]').val();
    var name = $('input[name=applicant]').val();
    ConfirmAlert.fire({
        icon: 'info',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will confirm the franchise application for approval</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Confirm',
    })
    .then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            const data = {
                id: id,
                _method: 'PATCH'
            };
            async function APIrequest() {
                return await axios.post('/api/update/confirm-franchise-application', data, {
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                SweetAlert.fire({
                    icon: 'success',
                    html: `
                    <h4 class="mb-0">Done</h4>
                    <small>${response.data.Message}</small>
                    
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

                    <div class="mt-4">
                        <a wire:navigate class="btn btn-sm btn-primary" href="/admin/view-application/${id}">Close</a>
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
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
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

    axios.post('/admin/application-form', formData, {
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

    axios.post('/admin/permit-form', formData, {
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

    axios.post('/admin/confirmation-form', formData, {
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

    axios.post('/admin/provisional-form', formData, {
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

$(document).on('click', "#reject-application", function(e) {
    e.preventDefault();
    var id = $('input[name=id]').val();

    DelAlert.fire({
        icon: 'warning',
        html: `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will reject the franchise application of this applicant.</small>
            
            <div class="mt-3">
                <label for="rejectComment" class="form-label">Comment/Reason <span class="text-danger">*</span></label>
                <textarea id="rejectComment" class="form-control" rows="3" placeholder="Enter reason for rejection"></textarea>
            </div>
            
            <div class="mt-3 mb-4">
                <label class="form-label">Select requirements to be reuploaded:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="proofOfCitizenship">
                    <small class="form-check-label" for="proofOfCitizenship">
                        Proof of Citizenship
                    </small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="todaClearance">
                    <small class="form-check-label" for="todaClearance">
                        TODA Clearance Certification
                    </small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="officialReceipt">
                    <small class="form-check-label" for="officialReceipt">
                        Official Receipt (OR)
                    </small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="certificateOfRegistration">
                    <small class="form-check-label" for="certificateOfRegistration">
                        Certificate of Registration (CR)
                    </small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="driversID">
                    <small class="form-check-label" for="driversID">
                        Drivers Identification Card
                    </small>
                </div>
            </div>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Reject',
        preConfirm: () => {
            const comment = $('#rejectComment').val().trim();
            if (!comment) {
                Swal.showValidationMessage('Reason is required');
            }
            
            return {
                comment,
                proofOfCitizenship: $('#proofOfCitizenship').is(':checked'),
                todaClearance: $('#todaClearance').is(':checked'),
                officialReceipt: $('#officialReceipt').is(':checked'),
                certificateOfRegistration: $('#certificateOfRegistration').is(':checked'),
                driversID: $('#driversID').is(':checked')
            };
        }
    })
    .then((result) => {
        if (result.isConfirmed && result.value.comment) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            
            const data = {
                id: id,
                comment: result.value.comment,
                proofOfCitizenship: result.value.proofOfCitizenship,
                todaClearance: result.value.todaClearance,
                officialReceipt: result.value.officialReceipt,
                certificateOfRegistration: result.value.certificateOfRegistration,
                driversID: result.value.driversID
            };

            async function APIrequest() {
                return await axios.delete('/api/delete/reject-franchise-application', {
                    data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                });
            }
            
            APIrequest()
                .then(response => {
                    SweetAlert.fire({
                        icon: 'success',
                        html: `
                        <h4 class="mb-0">Done</h4>
                        <small>${response.data.Message}</small>
                        <div class="mt-4">
                            <a wire:navigate class="btn btn-sm btn-primary" href="/admin/new-application">Close</a>
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
                        html: `<h4 class="mb-0">Oops...</h4><small>Something went wrong!</small>`,
                        confirmButtonColor: "#3a57e8"
                    });
                });
        }
    });
});


$(document).on('click', "#release-franchise", function(e){
    e.preventDefault();
    var id = $('input[name=id]').val();
    ConfirmAlert.fire({
        icon: 'info',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will release and approve the franchise application</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Approve',
    })
    .then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            const data = {
                id: id,
                _method: 'PATCH'
            };
            async function APIrequest() {
                return await axios.post('/api/update/approve-franchise-application', data, {
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                SweetAlert.fire({
                    icon: 'success',
                    html: `
                    <h4 class="mb-0">Done</h4>
                    <small>${response.data.Message}</small>

                    <div class="mt-4">
                        <a wire:navigate class="btn btn-sm btn-primary" href="/admin/view-application/${id}">Close</a>
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
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});

$(document).on('click', "#confirm-renewal", function(e){
    e.preventDefault();
    var id = $('input[name=id]').val();
    var name = $('input[name=applicant]').val();
    ConfirmAlert.fire({
        icon: 'info',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will confirm the franchise application for approval</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Confirm',
    })
    .then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            const data = {
                id: id,
                _method: 'PATCH'
            };
            async function APIrequest() {
                return await axios.post('/api/update/confirm-franchise-renewal', data, {
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                SweetAlert.fire({
                    icon: 'success',
                    html: `
                    <h4 class="mb-0">Done</h4>
                    <small>${response.data.Message}</small>
                    
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

                    <div class="mt-4">
                        <a wire:navigate class="btn btn-sm btn-primary" href="/admin/view-application/${id}">Close</a>
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
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});

$(document).on('click', "#renew-franchise", function(e){
    e.preventDefault();
    var id = $('input[name=id]').val();
    ConfirmAlert.fire({
        icon: 'info',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will approve the franchise renewal</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Approve',
    })
    .then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            const data = {
                id: id,
                _method: 'PATCH'
            };
            async function APIrequest() {
                return await axios.post('/api/update/approve-franchise-renewal', data, {
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                SweetAlert.fire({
                    icon: 'success',
                    html: `
                    <h4 class="mb-0">Done</h4>
                    <small>${response.data.Message}</small>

                    <div class="mt-4">
                        <a wire:navigate class="btn btn-sm btn-primary" href="/admin/view-application/${id}">Close</a>
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
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});

$(document).on('click', "#reject-renewal", function(e){
    e.preventDefault();
    var id = $('input[name=id]').val();
    var userID = $('input[name=userID]').val();
    DelAlert.fire({
        icon: 'warning',
        html: `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will reject the franchise application of this applicant.</small>
            
            <div class="mt-3">
                <label for="rejectComment" class="form-label">Comment/Reason <span class="text-danger">*</span></label>
                <textarea id="rejectComment" class="form-control" rows="3" placeholder="Enter reason for rejection"></textarea>
            </div>
            
            <div class="mt-3 mb-4">
                <label class="form-label">Select requirements to be reuploaded:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="proofOfCitizenship">
                    <small class="form-check-label" for="proofOfCitizenship">
                        Proof of Citizenship
                    </small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="todaClearance">
                    <small class="form-check-label" for="todaClearance">
                        TODA Clearance Certification
                    </small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="officialReceipt">
                    <small class="form-check-label" for="officialReceipt">
                        Official Receipt (OR)
                    </small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="certificateOfRegistration">
                    <small class="form-check-label" for="certificateOfRegistration">
                        Certificate of Registration (CR)
                    </small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="driversID">
                    <small class="form-check-label" for="driversID">
                        Drivers Identification Card
                    </small>
                </div>
            </div>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Reject',
        preConfirm: () => {
            const comment = $('#rejectComment').val().trim();
            if (!comment) {
                Swal.showValidationMessage('Reason is required');
            }
            
            return {
                comment,
                proofOfCitizenship: $('#proofOfCitizenship').is(':checked'),
                todaClearance: $('#todaClearance').is(':checked'),
                officialReceipt: $('#officialReceipt').is(':checked'),
                certificateOfRegistration: $('#certificateOfRegistration').is(':checked'),
                driversID: $('#driversID').is(':checked')
            };
        }
    })
    .then((result) => {
        if (result.isConfirmed && result.value.comment) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            
            const data = {
                id: id,
                userID: userID,
                comment: result.value.comment,
                proofOfCitizenship: result.value.proofOfCitizenship,
                todaClearance: result.value.todaClearance,
                officialReceipt: result.value.officialReceipt,
                certificateOfRegistration: result.value.certificateOfRegistration,
                driversID: result.value.driversID
            };
            async function APIrequest() {
                return await axios.delete('/api/delete/reject-franchise-renewal', {
                    data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                SweetAlert.fire({
                    icon: 'success',
                    html: `
                    <h4 class="mb-0">Done</h4>
                    <small>${response.data.Message}</small>

                    <div class="mt-4">
                        <a wire:navigate class="btn btn-sm btn-primary" href="/admin/renewal">Close</a>
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
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});

$(document).on("click", '#renew-franchise-walk-in', function(){
    var id = $(this).data('id');
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
            <a wire:navigate class="btn rounded-1 btn-primary shadow-lg me-2" href="/admin/walk-in-renew-franchise/Z5txoj0MSAUlfZFnLCTiFpXwkxkXRNyAbnsoubOS0otpu7MWfXnK5wrjbEhKpjUSVFFfxZFjZVvVVFW3Ti6TJH8iW_ISx6w-dmhDdc_m_VxrJN2Ws9GZxozz2VcpLhBFD_QblTga1SmzENWLsCFGwQ:ISlAKCMqZiYlXjEyMzQ1Ng/${id}">Existing Unit</a>
            <a wire:navigate class="btn rounded-1  btn-success shadow-lg" href="/admin/walk-in-renew-franchise/q0CwLsWJBelHrDYiAuk-xgVVFtLpyPnkGPiDKIk7oC0HMfeSbTU8QnQ49oSI7FfEi1-oTPyckxEcbK4l5UbB3YstLUe1vDtwHWk8BcNl-Oa5qrYVSEd9gbUMifkKmRzZ6xOJqjpf4tXZcreBWVK5vQ:ISlAKCMqZiYlXjEyMzQ1Ng/${id}">New Unit</a>
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
            return await axios.post('/api/update/walk-in-submit-renewal', formData, {
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
                        <a wire:navigate class="btn btn-sm rounded-1 btn-primary shadow-lg me-2" href="/admin/dashboard">Return to Dashboard</a>
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

$(document).on('change', "#selected-category", function(e){
        const formData = new FormData();
        formData.append('id', $(this).val());
        async function APIrequest() {
            return await axios.post('/api/get/users', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('#selected-category-result').html(response.data.Users);
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
});

$(document).on('change', "#category-user", function(e) {
    var value = $(this).val();

    if(value === '1') {
        $('#show-create-account').show(100);
        // Add 'required' attribute to each input when the section is shown
        $('#body-number').attr('required', true);
        $('#prev-username').attr('required', true);
        $('#password').attr('required', true);
    } else {
        $('#show-create-account').hide(100);
        // Remove 'required' attribute when the section is hidden
        $('#body-number').removeAttr('required');
        $('#prev-username').removeAttr('required');
        $('#password').removeAttr('required');
    }
});

$(document).on('input', "#body-number", function(e) {
    var value = $(this).val();
    
    // Ensure the value is treated as a string
    value = value.toString();

    // Add leading zeros based on the length of the number
    if (value.length === 1) {
        value = '00' + value;  // Add two zeros for single digit
    } else if (value.length === 2) {
        value = '0' + value;  // Add one zero for two digits
    }

    var selectedOption = $('#selected-category option:selected');
    var category = selectedOption.data('category');

    $('#prev-username').val(category + '-' + value);
});

$(document).on('submit', "#create-previous-records", function(e) {
    e.preventDefault();

    // Check if #show-create-account is visible
    if ($("#show-create-account").is(":visible")) {
        var password = document.getElementById("prev-password").value.trim();
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
    }

    // If validation passes or #show-create-account is not visible
    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        async function APIrequest() {
            return await axios.post('/api/create/previous-records', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            });
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $('.processing').removeClass('d-flex');

            SweetAlert.fire({
                icon: 'success',
                html: `
                <h4 class="mb-0">Done</h4>
                <small>${response.data.Message}</small>
                <div class="mt-4">
                    <a wire:navigate class="btn btn-sm btn-primary" href="/admin/add-previous-data">Close</a>
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



$(document).on('change', 'input[name="renew"]', function() {
    var renewalDate = new Date($(this).val());
    // Add 1 year to the renewal date
    renewalDate.setFullYear(renewalDate.getFullYear() + 1);
    
    // Format the new expiration date to YYYY-MM-DD
    var day = String(renewalDate.getDate()).padStart(2, '0');
    var month = String(renewalDate.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
    var year = renewalDate.getFullYear();
    var expirationDate = year + '-' + month + '-' + day;

    // Set the expiration date field
    $('input[name="expire"]').val(expirationDate);
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

$(document).on('submit', '#generate-report', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    // Show SweetAlert loading message
    SweetAlert.fire({
        icon: 'info',
        html: `<h4 class="mb-0">Processing...</h4><small>Generating PDF ...</small>`,
        allowOutsideClick: false,
        showConfirmButton: false
    });

    // Delay the execution for 2 seconds
    setTimeout(function() {
        axios.post('/admin/generate-report', formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        }).then(function(response) {
            if (response.status === 204) {
                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Opss...</h4><small>No Data Available</small>`,
                    confirmButtonColor: "#3a57e8"
                });
                return; // Exit early
            }

            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>Wait for the file to be downloaded</small>`,
                confirmButtonColor: "#3a57e8"
            });

            var data = response.data;
            var tempDiv = $('<div></div>').html(data);

            var style = '<style>#content { font-size: 12px; }</style>';
            tempDiv.prepend(style);

            $('#content').append(tempDiv);

                        // Get year and month from form data
            // Get references to the form inputs
            const year = formData.get('year');
            const monthIndex = formData.get('month'); // This will be the numeric month (01-12)
            const printAllChecked = document.getElementById('printAll').checked; // Check if printAll is checked

            // Month names mapping
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            // Get the month name if a month is selected
            const monthName = monthIndex ? `-${monthNames[parseInt(monthIndex) - 1]}` : ''; // Append month name if exists

            // Declare filename variable
            let filename;

            // Determine filename based on printAll checkbox state
            if (printAllChecked) { 
                // If printAll is checked
                filename = `Franchise Application/Renewal Report.pdf`;
            } else {
                // If printAll is NOT checked
                filename = `Franchise Application/Renewal Report-${year}${monthName}.pdf`;
            }

            // Use the filename in html2pdf
            html2pdf()
                .from(tempDiv[0])
                .set({
                    margin: 0.5,
                    filename: filename, // Use the dynamic filename
                    html2canvas: { scale: 5 },
                    jsPDF: { orientation: 'landscape', unit: 'in', format: 'legal' }
                })
                .save()
                .then(function () {
                    tempDiv.remove();
            });
        })
        .catch(function(error) {
            console.error('Error fetching the content:', error);
        });
    }, 2000); // 2000 milliseconds = 2 seconds
});


$(document).on('keyup', '#search-input', function() {
    var searchTerm = $(this).val().toLowerCase().replace(/^\s+|\s+$/g, ''); // Remove leading/trailing spaces only
    var noResults = true;

    // Filter through each row in the tbody except those with the 'exclude-from-search' class
    $('#category-users-data-analytics tbody tr').not('.exclude-from-search').each(function() {
        var rowText = $(this).text().toLowerCase();

        // Check if row contains the search term
        if (rowText.includes(searchTerm)) {
            $(this).show();  // Show rows that match the search term
            noResults = false; // At least one row matches
        } else {
            $(this).hide();  // Hide rows that don’t match
        }
    });

    // Show 'No data found' message if no rows match
    if (noResults) {
        $('#category-users-data-analytics tbody').append('<tr class="no-data"><td colspan="7" class="text-center">No data found</td></tr>');
    } else {
        $('#category-users-data-analytics tbody .no-data').remove(); // Remove 'No data found' message if there are matching rows
    }
});

$(document).on('change', '#printAll', function () {
    // Check if the toggle switch is checked
    if ($(this).is(':checked')) {
        // Disable all input and select fields
        $('#generate-report input, #generate-report select').prop('disabled', true);
        // Enable the toggle itself
        $(this).prop('disabled', false);
    } else {
        // Enable all input and select fields
        $('#generate-report input, #generate-report select').prop('disabled', false);
    }
});
