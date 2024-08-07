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

