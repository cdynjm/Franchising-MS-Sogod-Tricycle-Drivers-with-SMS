var currentTab = 0; // Current tab is set to be the first tab (0)

var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-sm btn-primary',
        cancelButton: 'btn btn-sm btn-secondary ms-2'
    },
    buttonsStyling: false
});

document.addEventListener('livewire:navigated', () => { 
    showTab(currentTab); // Display the current tab
});

function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("wizard-tab");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        var nextBtn = document.getElementById("nextBtn");

        nextBtn.innerHTML = "Submit";
       
     
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    //... and run a function that displays the correct step indicator:
    fixStepIndicator(n);
}

function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("wizard-tab");

    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;

    // Hide the current tab:
    x[currentTab].style.display = "none";

    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;

    // If you have reached the last tab (currentTab == 3), show SweetAlert before submission:
    if (currentTab == 3) {
        SweetAlert.fire({
            icon: 'warning',
            title: 'Review Your Application',
            html: `<p>Please review your application before submitting.</p>`,
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3a57e8',
            cancelButtonColor: '#6c757d',
            allowOutsideClick: false, // Prevent closing on outside click
            allowEscapeKey: false,   
        }).then((result) => {
            if (result.isConfirmed) {
                // Allow form submission by changing the button type to submit
                $("#submit-application").submit();
            } else {
                // User canceled, go back to the previous tab
                currentTab--; // Adjust the tab index
                x[currentTab].style.display = "block"; // Show the previous tab
            }
        });
    } else {
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }
}


function validateForm() {
    var x, y, i, valid = true;
    x = document.getElementsByClassName("wizard-tab");
    y = x[currentTab].getElementsByTagName("input");

    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // Skip the middle initial field validation
        if (y[i].name === "middleinitial") continue;

        // If a field is empty...
        if (y[i].value.trim() === "") {
            // Add an "invalid" class to the field:
            y[i].className += " invalid";
            // Set the current valid status to false:
            valid = false;
        }
    }

    // Validate terms and conditions checkbox on the first tab
    if (currentTab == 0) {
        var checkbox = document.getElementById("agreeCheckbox");
        if (!checkbox.checked) {
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Error</h4><small>Please check the terms and conditions to proceed</small>`,
                confirmButtonColor: "#3a57e8"
            });
            return false;
        }
    }

    // Validate select dropdown on the second tab
    if (currentTab == 1) {
        var select = document.getElementById("category");
        if (select.value.trim() === "") {
            select.className += " invalid";
            valid = false;
        }
    }

    // Password validation on the third tab
    if (currentTab == 2) {
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
    }

    // Handle invalid fields
    if (!valid) {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Empty Field(s)</h4><small>Do not leave an empty field</small>`,
            confirmButtonColor: "#3a57e8"
        });
    } else {
        document.getElementsByClassName("list-item")[currentTab].className += " finish";
    }

    return valid;
}


function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("list-item");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
}
