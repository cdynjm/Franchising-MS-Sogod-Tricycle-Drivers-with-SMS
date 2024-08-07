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