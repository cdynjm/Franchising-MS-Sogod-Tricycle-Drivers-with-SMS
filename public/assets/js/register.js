$(document).on("keyup", '#bodyNumber', function() {
    combineValues();
});

$(document).on("change", '#category', function() {
    combineValues();
});

function combineValues() {
    var bodyNumber = $('#bodyNumber').val();
    var category = $('#category option:selected').text();

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