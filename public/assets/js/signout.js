$(document).on('click', "#sign-out", function(e){
    e.preventDefault();
    Swal.fire({
        position: 'center',
        icon: 'info',
        html: `<h4 class="mb-0">Signing Out...<h4>`,
        allowOutsideClick: false,
        showConfirmButton: false
    });
    const formData = new FormData();
    async function APIrequest() {
        return await axios.post('/logout', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        if(response.data.Error == 0)
            location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});