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

    axios.post('/admin/application-form/', formData, {
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

    axios.post('/admin/permit-form/', formData, {
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

    axios.post('/admin/confirmation-form/', formData, {
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

    axios.post('/admin/provisional-form/', formData, {
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

$(document).on('click', "#reject-application", function(e){
    e.preventDefault();
    var id = $('input[name=id]').val();
    DelAlert.fire({
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will reject and delete the franchise application of this applicant permanently.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Reject',
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
            const data = {id: id};
            async function APIrequest() {
                return await axios.delete('/api/delete/reject-franchise-application', {
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
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
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
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will reject and delete the franchise application of this applicant permanently.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Reject',
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
                userID: userID
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
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});