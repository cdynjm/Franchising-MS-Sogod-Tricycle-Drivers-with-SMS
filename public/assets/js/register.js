
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



$(document).on("keyup", '#bodyNumber', function() {
    combineValues();
});

$(document).on("change", '#category', function() {
    combineValues();
});

function combineValues() {
    var bodyNumber = $('#bodyNumber').val();
    var category = $('#category option:selected').data('value');

    if (bodyNumber.length < 3) {
        bodyNumber = bodyNumber.padStart(3, '0');
    }
    
    var combinedValue = category + '-' + bodyNumber;
    var slugValue = createSlug(combinedValue);

    $('#username').val(slugValue);
}

function createSlug(text) {
    return text.toUpperCase()
               .replace(/\s+/g, '-') // Remove spaces
               .replace(/[^\w\-]+/g, '') // Remove all non-word characters
               .replace(/\-\-+/g, '-') // Replace multiple hyphens with a single hyphen
               .replace(/^-+/, '') // Trim hyphens from the start of the text
               .replace(/-+$/, ''); // Trim hyphens from the end of the text
}

$(document).on('submit', "#submit-application", function(e){
    e.preventDefault();

    $('.processing').show(100);
    $('.processing').addClass('d-flex');

    setTimeout(() => {
        const formData = new FormData(this);
        async function APIrequest() {
            return await axios.post('/submit-application', formData, {
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
                    <a wire:navigate class="btn btn-sm btn-primary" href="/login">Close</a>
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

$(document).on('click', '#show-retype-password', function () {
    const retypePasswordField = $('#retype-password');
    const type = retypePasswordField.attr('type') === 'password' ? 'text' : 'password';
    retypePasswordField.attr('type', type);
    $(this).find('i').toggleClass('mdi-eye-outline mdi-eye-off-outline');
});